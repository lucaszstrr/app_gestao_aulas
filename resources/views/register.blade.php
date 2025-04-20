@extends('layouts.app')

@section('content')
<main>
    <section class="main-content">
        <div class="create-account-interface">
            <h2 class="text-login">Crie sua conta agora mesmo!</h2>

            <form method="POST" action="{{ route('register-account') }}">
                @csrf
                    <div>
                        <h3 class="login-input">Nome</h3>
                        <input type="text" name="name" class="input" placeholder="Insira seu nome aqui" required>

                        <h3 class="login-input">Email</h3>
                        <input type="email" name="email" class="input" placeholder="Insira seu email aqui" required>

                        <h3 class="login-input">Senha</h3>
                        <input type="password" name="password" class="input" placeholder="Insira sua senha aqui" required>

                        <h3 class="login-input">Formação</h3>
                        <input type="text" name="area" class="input" placeholder="Insira sua formação aqui" required>
                    </div>
                <button linkto="{{ route('register-account') }}" type="submit" class="login-btn">Criar Conta</button>
            </form>

            <!-- <form method="POST" action="{{ route('register-account') }}">
                @csrf
                <input type="text" name="name" class="input" placeholder="Insira seu nome aqui" required>
                <input type="email" name="email" class="input" placeholder="Insira seu email aqui" required>
                <input type="password" name="password" class="input" placeholder="Insira sua senha aqui" required>
                <input type="text" name="area" class="input" placeholder="Insira sua formação aqui" required>
                <button linkto="{{ route('register-account') }}" type="submit" class="login-btn">Criar Conta</button>
            </form> -->
        </div>
    </section>
</main>
@endsection