<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Services\GreetService;
use App\Services\PixService;
use Illuminate\Support\Facades\Auth;


class FinancesController extends Controller
{
    public function index()
    {
        //USER
        $userLogged = Auth::user();

        $userName = $userLogged->name;

        $user = User::where("id", $userLogged->id)->first();

        $firstName = explode(' ', $userLogged->name)[0];

        $upperLoggedName = strtoupper($userLogged->name);

        //MANAGEMENT
        $totalClasses = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $classes = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $roomRental = $classes * 20;

        //STUDENT
        $students = Student::where("teacher_id", $userLogged->id)->get();

        //SERVICES
        $greetService = new GreetService();

        $greet = $greetService->greet();

        $pixService = new PixService();

        if($userLogged["pix-key"] == null){
            return redirect()->route('perfil')->withErrors([
                "key-dont-exists" => "Chave não cadastrada"
            ]);
        }

        return view('finances', compact('students', 'userLogged', 'totalClasses', 'roomRental', 'greet', 'firstName', 'pixService', 'upperLoggedName'));
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
            "beneficiary_pix_key" => "51351383000183",
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


    public function generatePix(string $id)
    {
        $userLogged = Auth::user();

        $userFirstName = strtoupper(explode(' ', $userLogged->name)[0]);

        $student = Student::where("id", $id)->first();

        $studentFirstName = strtoupper(explode(' ', $student->name)[0]);

        $management = Management::where("student_id", $student->id)->first();

        if($management->quantity_classes == 0){
            return back()->withErrors([
                "invalid-pix" => "Valor de pix inválido"
            ]);
        }

        $pixService = new PixService();

        if($userLogged["pix-key-type"] == "number"){
            $pix = $pixService->gerarPix(
                chavePix: "+55".$userLogged["pix-key"], 
                valor: $management->total_value, 
                beneficiario: $userFirstName,
                cidade: "GUARAPUAVA",
                descricao: 'AULAS '.$studentFirstName,
                txid: 'ALUG' . time()
            );

            $registerPayment = Payment::create([
                "teacher_id" => $userLogged->id,
                "responsible_id" => $student->responsible_id,
                "payer_pix_key" => 0,
                "beneficiary_pix_key" => "+55".$userLogged["pix-key"],
                "classes_total_value" => $management->total_value,
                "beneficiary" => $userFirstName,
                "rent" => false
            ]);

            return view('payment-classes', [
                'codigoPix' => $pix['codigo'],
                'qrCode' => $pix['qr_code'],
                'aluguel' => $management->total_value
            ]);
        }

        $pix = $pixService->gerarPix(
            chavePix: $userLogged["pix-key"], 
            valor: $management->total_value, 
            beneficiario: $userFirstName,
            cidade: "GUARAPUAVA",
            descricao: 'AULAS '.$studentFirstName,
            txid: 'ALUG' . time()
        );

        $registerPayment = Payment::create([
            "teacher_id" => $userLogged->id,
            "responsible_id" => $student->responsible_id,
            "payer_pix_key" => 0,
            "beneficiary_pix_key" => $userLogged["pix-key"],
            "classes_total_value" => $management->total_value,
            "beneficiary" => $userFirstName,
            "rent" => false
        ]);

        return view('payment-classes', [
            'codigoPix' => $pix['codigo'],
            'qrCode' => $pix['qr_code'],
            'aluguel' => $management->total_value
        ]);
    }
}
