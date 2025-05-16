<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLogged = Auth::user();

        $userName = $userLogged->name;

        $time = Carbon::now('America/Sao_Paulo')->format('H:i:s');

        $firstName = explode(' ', $userLogged->name)[0];
        
        if($time >= '12:00:00' && $time <= '17:59:59'){
            $greet = "Boa tarde";
        }elseif($time >= '00:00:00' && $time <= '11:59:59'){
            $greet = "Bom dia";
        }elseif($time >= '18:00:00' && $time <= '23:59:59'){
            $greet = "Boa noite";
        }

        $user = User::where("id", $userLogged->id)->first();

        return view('profile', compact('greet', 'userName', 'user', 'firstName'));
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

        return redirect()->route('perfil');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
