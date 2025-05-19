<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Payment;
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

        $userName = $userLogged->name;

        $user = User::where("id", $userLogged->id)->first();

        $students = Student::where("teacher_id", $userLogged->id)->get();

        $totalClasses = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $classes = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $roomRental = $classes * 20;

        $time = Carbon::now('America/Sao_Paulo')->format('H:i:s');

        $firstName = explode(' ', $userLogged->name)[0];

        $upperLoggedName = strtoupper($userLogged->name);

        if($time >= '12:00:00' && $time <= '17:59:59'){
            $greet = "Boa tarde";
        }elseif($time >= '00:00:00' && $time <= '11:59:59'){
            $greet = "Bom dia";
        }elseif($time >= '18:00:00' && $time <= '23:59:59'){
            $greet = "Boa noite";
        }

        $pixService = new PixService();

        if($userLogged["pix-key"] == null){
            return redirect()->route('perfil')->withErrors([
                "key-dont-exists" => "Chave não cadastrada"
            ]);
        }

        return view('finances', compact('students', 'userLogged', 'totalClasses', 'roomRental', 'time', 'greet', 'firstName', 'pixService', 'upperLoggedName'));
    }

    public function rentGeneratePix()
    {
        $userLogged = Auth::user();

        $quantityClasses = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $rentValue = $quantityClasses * 20;

        $userFirstName = strtoupper(explode(' ', $userLogged->name)[0]);

        $pixService = new PixService();

        $pix = $pixService->gerarPix(
            chavePix: "51351383000183", 
            valor: $rentValue, 
            beneficiario: "JOBIANA PADILHA ZENI",
            cidade: "GUARAPUAVA",
            descricao: 'ALUGUEL SALA PROF '.$userFirstName,
            txid: 'ALUG' . time()
        );

       $registerPayment = Payment::create([
            "teacher_id" => $userLogged->id,
            "payer_pix_key" => $userLogged["pix-key"],
            "beneficiary_pix_key" => "+5542998002359",
            "rent_value" => $rentValue,
            "beneficiary" => "JOBIANA PADILHA ZENI",
            "rent" => true
       ]);

        return view('payment', [
            'codigoPix' => $pix['codigo'],
            'qrCode' => $pix['qr_code'],
            'aluguel' => $rentValue
        ]);
    }
}
