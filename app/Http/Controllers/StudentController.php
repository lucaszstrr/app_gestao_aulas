<?php

namespace App\Http\Controllers;

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

        $validateStudent = $request->validate([
            "name" => "required | string",
            "age" => "nullable | integer",
            "school_year" => "required | string",
            "school" => "nullable | string",
            "number" => "nullable | integer | digits_between:10,11",
            "responsible" => "required | string",
            "responsible_number" => "required | integer | digits_between:10,11",
        ]);

        // if(!$validateStudent['number']){
        //     return back()->withInput()->withErrors([
        //         'number' => 'Numero inválido, deve ter apenas números'
        //     ]);
        // }

        // if(isEmpty($validateStudent['number']) && count($validateStudent['responsible_number']) != 11 ){
        //     return back()->withInput()->withErrors([
        //         'number-lenght' => 'Numero inválido, deve ter apenas números'
        //     ]);
        // }
        

        dd($validateStudent);

        // return redirect()->route('students');

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
