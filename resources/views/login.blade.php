@extends('layouts.app')

@section('content')
    <section class="main-content">
        <div class="login-interface">
            <h2 class="text-login">Faça seu login aqui!</h2>
            <form method="POST" action="{{ route('login-account') }}">
                @csrf
                    <div>
                        <h3 class="login-input">Email:</h3>
                        <input class="input" name="email" type="email" placeholder="Insira seu email aqui" required>

                        <h3 class="login-input">Senha:</h3>
                        <input  class="input" name="password" type="password" placeholder="Insira sua senha aqui" required> 

                        @error('credentials')
                            <p class="login-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Email e/ou senha incorretos!</p>
                        @enderror               
                    </div>

                    <p class="not-account">Ainda não tem uma conta ?<a class="link-not-account" href="{{ route('register') }}"> Criar conta</a></p>

                    <button linkto="{{ route('login-account') }}" type="submit" class="login-btn">Entrar</button>
            </form>
        </div>
    </section>
@endsection