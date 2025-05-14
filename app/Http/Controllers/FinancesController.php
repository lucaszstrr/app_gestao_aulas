<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class FinancesController extends Controller
{
    public function index()
    {
        $userLogged = Auth::user();

        $students = Student::where("teacher_id", $userLogged->id)->get();

        $totalClasses = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $classes = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $roomRental = $classes * 20;

        $time = Carbon::now('America/Sao_Paulo')->format('H:i:s');
        
        if($time >= '12:00:00' && $time <= '17:59:59'){
            $greet = "Boa tarde";
        }elseif($time >= '00:00:00' && $time <= '11:59:59'){
            $greet = "Bom dia";
        }elseif($time >= '18:00:00' && $time <= '23:59:59'){
            $greet = "Boa noite";
        }

        return view('finances', compact('students', 'userLogged', 'totalClasses', 'roomRental', 'time', 'greet'));
    }
}
