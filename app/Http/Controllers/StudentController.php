<?php

namespace App\Http\Controllers;

use App\Models\Responsible;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('add-student');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teacherId = Auth::id();

        $validateStudent = $request->validate([
            "name" => "required | string",
            "age" => "nullable | integer",
            "school_year" => "required | string",
            "school" => "nullable | string",
            "number" => "nullable | integer | digits_between:10,11",
            "responsible" => "required | string",
            "responsible_number" => "required | integer | digits_between:10,11",
        ]);

        if($validateStudent['school_year'] == 'fundamental 1'){
            $classValue = 90.00;
        }

        if($validateStudent['school_year'] == 'fundamental 2'){
            $classValue = 90.00;
        }

        if($validateStudent['school_year'] == 'ensino médio'){
            $classValue = 120.00;
        }

        if($validateStudent['school_year'] == 'ensino superior'){
            $classValue = 130.00;
        }


        $student = Student::create([
            "name" => $validateStudent['name'],
            "teacher_id" => $teacherId,
            "responsible" => $validateStudent['responsible'],
            "age" => $validateStudent['age'],
            "school_year" => $validateStudent['school_year'],
            "school" => $validateStudent['school'],
            "number" => $validateStudent['number'],
            "class_value" => $classValue
        ]);

        $responsible = Responsible::create([
            "student_id" => $student->id,
            "student" => $student->name,
            "name" => $validateStudent['responsible'],
            "number" => $validateStudent['responsible_number']
        ]);

        return redirect()->route('meus-alunos');

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
