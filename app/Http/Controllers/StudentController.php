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
        $userLogged = Auth::user();
        
        $students = Student::where('teacher_id', $userLogged->id)->get();

        return view('students', ['students' => $students]); 
    }

    public function indexRegisterStudent()
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
            $classValue = 100.00;
        }

        if($validateStudent['school_year'] == 'fundamental 2'){
            $classValue = 100.00;
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
            "responsible_number" => $validateStudent['responsible_number'],
            "age" => $validateStudent['age'],
            "school_year" => $validateStudent['school_year'],
            "school" => $validateStudent['school'],
            "number" => $validateStudent['number'],
            "class_value" => $classValue,
        ]);

        $createResponsible = Responsible::create([
            "student_id" => $student->id,
            "student" => $student->name,
            "name" => $validateStudent['responsible'],
            "number" => $validateStudent['responsible_number']
        ]);

        $responsible = Responsible::where("student_id", $student->id)->first();

        $student->update([
            "responsible_id" => $responsible->id
        ]);

        return redirect()->route('meus-alunos');
    }

    public function delete(string $id)
    {
        $userId = Auth::id();

        $student = Student::findOrFail($id);

        if($student->teacher_id !== $userId){
            abort(403, 'Ação não autorizada'); 
        }

        $student->delete();

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
    public function edit(Request $request, Student $student)
    {
        //
    }

    public function indexUpdateStudent(string $id)
    {
        $student = Student::findOrFail($id);

        $responsible = Responsible::where("student_id", $student->id)->first();

        return view('edit-student', compact('student', 'responsible'));
    }
   
    public function update(Request $request, Student $student, string $id)
    {

        $userId = Auth::id();

        $student = Student::findOrFail($id);

        $responsible = Responsible::where("student_id", $student->id)->first();

        if($student->teacher_id !== $userId){
            abort(403, 'Ação não autorizada'); 
        }


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
            $classValue = 100.00;
        }

        if($validateStudent['school_year'] == 'fundamental 2'){
            $classValue = 100.00;
        }

        if($validateStudent['school_year'] == 'ensino médio'){
            $classValue = 120.00;
        }

        if($validateStudent['school_year'] == 'ensino superior'){
            $classValue = 130.00;
        }

        $student->update([
            "name" => $validateStudent['name'],
            "responsible" => $validateStudent['responsible'],
            "age" => $validateStudent['age'],
            "school_year" => $validateStudent['school_year'],
            "school" => $validateStudent['school'],
            "number" => $validateStudent['number'],
            "class_value" => $classValue
        ]);

        $responsible->update([
            "student_id" => $student->id,
            "student" => $student->name,
            "name" => $validateStudent['responsible'],
            "number" => $validateStudent['responsible_number']
        ]);

        return redirect()->route('meus-alunos');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
