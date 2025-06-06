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


    public function store(Request $request)
    {
        $validateUser = $request->validate([
            "name" => "required | string | max:100",
            "email" => "required | email | max:120",
            "password" => "required | string | min:7",
            "area" => "required | string | max:100"
        ]);

        if(strlen($validateUser["name"]) <= 2){
            return back()->withInput()->withErrors([
                "name-lenght" => "Nome inválido"
            ]);
        }

        $validateEmail = User::where('email', $validateUser['email'])->first();

        if($validateEmail){
            return back()->withInput()->withErrors([
                "email" => "Este email já foi utilizado!"
            ]);
        }

        if(strlen($validateUser['password'] < 7)){
            return back()->withInput()->withErrors([
                'password' => 'A senha deve ter no mínimo 7 caracteres'
            ]);
        }

        if(strlen($validateUser["area"]) <= 2){
            return back()->withInput()->withErrors([
                "area-lenght" => "Area inválido"
            ]);
        }

        $user = User::create([
            "name" => $validateUser['name'],
            "email" => $validateUser['email'],
            "password" => $validateUser['password'],
            "area" => $validateUser['area'],
        ]);

        return redirect()->route('admin-professor');
    }


    public function indexLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validateLogin = $request->validate([
            "email" => "required | email | max:100",
            "password" => "required | string"
        ]);

        if(Auth::attempt($validateLogin)){
            $userLogged = Auth::user();

            if($userLogged->role == 'admin'){
                return redirect()->route('admin-menu');
            }

            return redirect()->route('menu-professor');
        }

        return back()->withInput()->withErrors([
            "credentials" => "As credenciais não coincidem"
        ]);
    }

    public function changePassword(Request $request)
    {
        $userLogged = Auth::user();

        $user = User::where("id", $userLogged->id)->first();

        $validatePassword = $request->validate([
            "password" => "required | string",
            "new_password" => "required | string"
        ]);

        if(!Hash::check($validatePassword["password"], $userLogged->password)){
            return back()->withErrors([
                "incorrect-password" => "Senha incorreta"
            ]);
        }

        if(strlen($validatePassword["new_password"]) < 7){
            return back()->withInput()->withErrors([
                "password-lenght" => "A senha deve ter no minimo 7 caracteres"
            ]);
        }

        $user->password = Hash::make($validatePassword["new_password"]);
        $user->save();

        return back()->with('new-password', 'Senha atualizada!');
    }
    
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
