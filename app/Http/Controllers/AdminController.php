<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Responsible;
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
    

    public function indexTeacher(string $id)
    {

        $teacher = User::where("id", $id)->first();

        return view('admin-edit-teacher', compact('teacher'));

    }
    public function editTeacher(Request $request, string $id)
    {
        $teacher = User::where("id", $id)->first();

        $validateUser = $request->validate([
            "name" => "required | string | max:100",
            "email" => "required | email | max:120",
            "area" => "required | string | max:100"
        ]);

        if(strlen($validateUser["name"]) <= 2){
            return back()->withInput()->withErrors([
                "name-lenght" => "Nome inválido"
            ]);
        }

        if(strlen($validateUser["area"]) <= 2){
            return back()->withInput()->withErrors([
                "area-lenght" => "Area inválido"
            ]);
        }

        $teacher->update($validateUser);

        return redirect()->route('admin-professor')->with([
            "teacher-updated" => "Professor atualizado"
        ]);
        
    }


    public function removeTeacher(string $id)
    {

        $userLogged = Auth::user();

        if($userLogged->role != 'admin'){
            abort(403, 'Ação não autorizada'); 
        }

        $teacher = User::where("id", $id)->first();

        $managements = Management::where("teacher_id", $id)->get();

        $students = Student::where("teacher_id", $id)->get();

        foreach($students as $student){
            $responsible = Responsible::where("student_id", $student->id)->first();

            $responsible->delete();
        }

        foreach($managements as $management){
            $management->delete();
        }
            
        $teacher->delete();

        return back()->with([
            "teacher-deleted" => "O professor foi deletado com sucesso!"
        ]);

    }
}
