<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\GreetService;

class UserController extends Controller
{
    public function index()
    {
        $userLogged = Auth::user();

        $userName = $userLogged->name;

        $firstName = explode(' ', $userLogged->name)[0];
        
        $greetService = new GreetService();

        $greet = $greetService->greet();

        $user = User::where("id", $userLogged->id)->first();

        return view('profile', compact('greet', 'userName', 'user', 'firstName', 'userLogged'));
    }


    public function addPix(Request $request)
    {
        $userLogged = Auth::user();

        $validateKey = $request->validate([
            "pix-key" => "required | string",
            "pix-key-type" => "required | string"
        ]);

        if($validateKey["pix-key-type"] == 'cpf' && strlen($validateKey["pix-key"]) != 11){
            return back()->withInput()->withErrors([
                'cpf-key-size' => 'Tamanho da chave não é válido'
            ]);
        }

        if($validateKey["pix-key-type"] == 'number' && strlen($validateKey["pix-key"]) != 11){
            return back()->withInput()->withErrors([
                'number-key-size' => 'Tamanho da chave não é válido'
            ]);
        }

        if($validateKey["pix-key-type"] == 'cnpj' && strlen($validateKey["pix-key"]) != 14){
            return back()->withInput()->withErrors([
                'cnpj-key-size' => 'Tamanho da chave não é válido'
            ]);
        }

        if($validateKey["pix-key-type"] == 'random' && strlen($validateKey["pix-key"]) != 32){
            return back()->withInput()->withErrors([
                'random-key-size' => 'Tamanho da chave não é válido'
            ]);
        }

        $user = User::where("id", $userLogged->id)->first();
        
        $user->update($validateKey);
        $user->save();

        return back()->with('success-key', 'Chave cadastrada');
    }


    public function updateUserName(Request $request)
    {
        $userLogged = Auth::user();

        $user = User::where("id", $userLogged->id)->first();

        $validateUser = $request->validate([
            "name" => "nullable | string | max:100",
            "area" => "nullable | string | max:100"
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

        if($validateUser["name"] == null || $validateUser["area"] == null){
            return back()->withInput()->withErrors([
                "empty-spaces" => "Sem entrada"
            ]);
        }

        $user->update($validateUser);
        $user->save();

        return back()->with('success', 'Operação realizada com sucesso!');
    }
}
