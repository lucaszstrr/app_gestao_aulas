<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $teachers = User::all();

        return view('admin-menu', compact('students', 'teachers'));
    }


    public function teachers()
    {
        $teachers = User::where("role", "user")->get();

        $students = Student::all();

        $managements = Management::all();
       
        return view('admin-teachers', compact('teachers', 'managements', 'students'));

    }
    

    public function editTeacher(string $id)
    {


        
    }


    public function removeTeacher(string $id)
    {



    }
}
