<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Student;
use App\Models\User;
use App\Services\PixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $firstName = explode(' ', $userLogged->name)[0];
        
        if($time >= '12:00:00' && $time <= '17:59:59'){
            $greet = "Boa tarde";
        }elseif($time >= '00:00:00' && $time <= '11:59:59'){
            $greet = "Bom dia";
        }elseif($time >= '18:00:00' && $time <= '23:59:59'){
            $greet = "Boa noite";
        }

        return view('finances', compact('students', 'userLogged', 'totalClasses', 'roomRental', 'time', 'greet', 'firstName'));
    }

    public function rentGeneratePix()
    {
        $userLogged = Auth::user();

        $validateUserKey = User::where("id", $userLogged->id)->first();

        if($validateUserKey["pix-key"] == null){
            return back()->withErrors([
                "key-dont-exists" => "Chave não cadastrada"
            ]);
        }

        $owner = User::where("owner", true)->first();

        $quantityClasses = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $rentValue = $quantityClasses * 20;

       

        $loggedFirstName = explode(' ', $userLogged->name)[0];

        $upperUserName = strtoupper($loggedFirstName);

        $upperOwnerName = strtoupper($owner->name);

        $pixService = new PixService();

        $payload = $pixService->gerarPix(
            chavePix: '+55'.$owner["pix-key"], 
            valor: $rentValue, 
            beneficiario: $upperOwnerName,
            cidade: 'GUARAPUAVA',
            descricao: 'ALUGUEL SALA PROF '.$upperUserName,
            txid: 'ALUG' . time()
        );

        return view('payment', [
            'codigoPix' => $payload['codigo'],
            'qrCode' => $payload['qr_code'],
            'aluguel' => $rentValue
        ]);
    }
}
