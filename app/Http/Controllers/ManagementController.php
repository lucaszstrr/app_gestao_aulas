<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLogged = Auth::user();
        
        $students = Student::where('teacher_id', $userLogged->id)->get();

        return view('menu', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Student $student, string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $findStudent = Student::findOrFail($id);

        $student = Student::where('id', $id)->first();

        $validateManagement = $request->validate([
            "quantity_classes" => "required | integer | digits_between:0,12"
        ]);

        $managementExists = Management::where( "student_id", $id)->first();

        if($managementExists){
            $valueClasses = $validateManagement["quantity_classes"] * $student->class_value;

            $managementExists->update([
                "quantity_classes" => $validateManagement["quantity_classes"],
                "total_value" => $valueClasses
            ]);

            $managementExists->save();

            return redirect()->route('menu-professor')->with('success', 'Presença atualizada com sucesso!');
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

    /**
     * Display the specified resource.
     */
    public function show(Management $management)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Management $management)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Management $management)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Management $management)
    {
        //
    }
}
