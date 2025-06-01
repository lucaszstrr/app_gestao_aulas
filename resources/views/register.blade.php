@extends('layouts.app')

@section('content')

    <section class="main-content">
        <div class="create-account-interface">
            <h2 class="text-login">Criar conta</h2>

            <form method="POST" action="{{ route('register-account') }}">
                @csrf
                    <div>
                        <h3 class="login-input">Nome:*</h3>
                        <input type="text" name="name" class="input" placeholder="Insira seu nome aqui" required>
                        @error('name-lenght')
                            <p class="error-name-lenght">O nome deve ter mais caracteres</p>
                        @enderror

                        <h3 class="login-input">Email:*</h3>
                        <input type="email" name="email" class="input" placeholder="Insira seu email aqui" required>
                        @error('email')
                            <p class="field-error">Este email já foi cadastrado!</p>
                        @enderror
                        
                        <h3 class="login-input">Senha:*</h3>
                        <input type="password" name="password" class="input" placeholder="Insira sua senha aqui" required>
                        @error('password')
                            <p class="field-error">A senha deve ter no mínimo 7 caracteres</p>
                        @enderror

                        <h3 class="login-input">Formação:*</h3>
                        <input type="text" name="area" class="input" placeholder="Insira sua formação aqui" required>
                        @error('area-lenght')
                            <p class="error-name-lenght">Este campo deve ter mais caracteres</p>
                        @enderror
                    </div>

                <p class="has-account">Já tem uma conta ?<a class="link-has-account" href="{{ route('login') }}"> Entrar</a></p>
                <button linkto="{{ route('register-account') }}" type="submit" class="login-btn">Criar Conta</button>
            </form>
        </div>
    </section>

@endsection