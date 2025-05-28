<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TableService;


class ManagementController extends Controller
{
    public function index()
    {
        $userLogged = Auth::user();
        
        $students = Student::where('teacher_id', $userLogged->id)->get();

        $totalValue = Management::where("teacher_id", $userLogged->id)->sum("total_value");

        $classes = Management::where("teacher_id", $userLogged->id)->sum("quantity_classes");

        $roomRental = $classes * 20;

        return view('menu', compact('students','totalValue', 'roomRental'));
    }


    public function store(Request $request, Student $student, string $id)
    {
        $userLogged = Auth::user();

        $student = Student::where('id', $id)->first();

        $validateManagement = $request->validate([
            "quantity_classes" => "required | integer | digits_between:0,12"
        ]);

        $managementExists = Management::where( "student_id", $id)->first();

        if($managementExists){
            if($validateManagement["quantity_classes"] >= 4){
                $student->class_value = $student->class_value - 10;
            }

            $valueClasses = $validateManagement["quantity_classes"] * $student->class_value;

            $managementExists->update([
                "class_value" => $student->class_value,
                "quantity_classes" => $validateManagement["quantity_classes"],
                "total_value" => $valueClasses
            ]);

            $managementExists->save();

            return redirect()->route('menu-professor')->with('success', 'Presença atualizada com sucesso!');
        }

        if($validateManagement["quantity_classes"] >= 4){
            $student->class_value = $student->class_value - 10;
        }

        $valueClasses = $validateManagement["quantity_classes"] * $student->class_value;

        Management::create([
            "student_id" => $student->id,
            "teacher_id" => $userLogged->id,
            "quantity_classes" => $validateManagement["quantity_classes"],
            "class_value" => $student->class_value,
            "total_value" => $valueClasses
        ]);

        return redirect()->route('menu-professor')->with('success', 'Presença atualizada com sucesso!');
    }

    
    public function updatePayment(Request $request, string $id)
    {
        $userLogged = Auth::user();

        $student = Student::findOrFail($id);

        $latestManagement = $student->managements()->latest()->first();
        
        if ($latestManagement) {
            $latestManagement->update([
                'paid' => $request->paid === 'true'
            ]);
        }

        return redirect()->route('menu-professor')->with('success', 'Pagamento atualizado!');
    }


    public function generateTable()
    {
        $userLogged = Auth::user();

        $students = Student::where("teacher_id", $userLogged->id)->get();

        $managements = Management::where("teacher_id", $userLogged->id)->get();

        $tableService = new TableService();
        
        return $tableService->generateTable($students);
    }


    public function resetClasses()
    {
        $userLogged = Auth::user();

        $students = Student::where("teacher_id", $userLogged->id)->get();

        $managements = Management::where("teacher_id", $userLogged->id)->get();

        foreach($students as $student){
            $management = Management::where("student_id", $student->id)->first();

            $management->update([
                "class_value" => $student->class_value
            ]);
        }

        foreach($managements as $management){
            $management->update([
                "quantity_classes" => 0,
                "total_value" => 0
            ]);
        }

        return redirect()->route('menu-professor')->withSuccess([
            "reseted-classes" => "All classes were reseted succesfully"
        ]);
    }
}
