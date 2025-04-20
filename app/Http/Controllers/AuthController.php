<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validateUser = $request->validate([
            "name" => "required | string | max:100",
            "email" => "required | email | max:120",
            "password" => "required | string | min:7",
            "area" => "required | string | max:100"
        ], [
            'email.unique' => 'Este e-mail já está cadastrado. Por favor, use outro.'
        ]);

        // $validateEmail = User::find($validateUser['email'], 'email');

        // if($validateEmail){
        //     return "This email already exists";
        // }

        $user = User::create([
            "name"=> $validateUser['name'],
            "email"=> $validateUser['email'],
            "password"=> $validateUser['password'],
            "area"=> $validateUser['area']
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
