<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function indexLogin()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $validateUser = $request->validate([
            "name" => "required | string | max:100",
            "email" => "required | email | max:120",
            "password" => "required | string | min:7",
            "area" => "required | string | max:100"
        ]);

        $validateEmail = User::where('email', $validateUser['email'])->first();

        if($validateEmail){
            return back()->withInput()->withErrors([
                "email" => "Este email já foi utilizado!"
            ]);
        }

        $user = User::create([
            "name" => $validateUser['name'],
            "email" => $validateUser['email'],
            "password" => $validateUser['password'],
            "area" => $validateUser['area'],
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $validateLogin = $request->validate([
            "email" => "required | email | max:100",
            "password" => "required | string | min:7"
        ]);

        $user = User::find($validateLogin["email"], "email");

        if($user){
            return "esse usuario ja existe";
        }

        if(Hash::check($validateLogin['password'], $user['password'])){
            Auth::login($user);

            return redirect()->route('home');
        }
    }
}
