@extends('layouts.app')

@section('content')
    <section class="main-content">
        <div class="login-interface">
            <h2 class="text-login">Seja bem-vindo(a)!</h2>

            <div>
                <h3 class="login-input">Email</h3>
                <input class="input" placeholder="Insira seu email aqui">

                <h3 class="login-input">Senha</h3>
                <input  class="input" placeholder="Insira sua senha aqui">
            </div>
        
            <button class="login-btn">Entrar</button>
        </div>
    </section>
@endsection