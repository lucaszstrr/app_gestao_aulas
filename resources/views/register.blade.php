@extends('layouts.app')

@section('content')
<main>
    <section class="main-content">
        <div class="create-account-interface">
            <h2 class="text-login">Seja bem-vindo(a)!</h2>

            <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                    <h3 class="login-input">Nome</h3>
                    <input class="input" placeholder="Insira seu nome aqui">

                    <h3 class="login-input">Email</h3>
                    <input class="input" placeholder="Insira seu email aqui">

                    <h3 class="login-input">Senha</h3>
                    <input  class="input" placeholder="Insira sua senha aqui">

                    <h3 class="login-input">Formação</h3>
                    <input class="input" placeholder="Insira sua formação aqui">
            
            </div>
        
            <button type="submit" class="login-btn">Criar Conta</button>
            </form>
        </div>
    </section>
</main>
@endsection