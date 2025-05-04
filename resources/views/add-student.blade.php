@extends('layouts.app-logged')

@section('content')

    <section class="main-content">
        <div class="register-student">
            <h2 class="text-login">Cadastre seus alunos</h2>
            <form method="POST" action="{{ route('cadastrar-aluno') }}">
                @csrf
                <h3 class="login-input">Nome:*</h3>
                <input class="input" name="name" type="text" placeholder="Insira o nome aqui" required>
                        
                <h3 class="login-input">Idade:</h3>
                <input class="input" name="age" type="number" placeholder="Insira a idade aqui" nullable>
                        
                <h3 class="login-input">Nível Escolar:*</h3>
                <select class="input" name="school_year" required>
                    <option class="input-option" value="fundamental 1">Fundamental 1</option>
                    <option class="input-option" value="fundamental 2">Fundamental 2</option>
                    <option class="input-option" value="ensino médio">Ensino Médio</option>
                    <option class="input-option" value="ensino superior">Ensino Superior</option>
                </select>
                        
                <h3 class="login-input">Escola:</h3>
                <input class="input" name="school" type="text" placeholder="Insira a escola aqui" nullable>
                        
                <h3 class="login-input">Número de celular:</h3>
                <input class="input" name="number" type="number" placeholder="Insira número de celular aqui" nullable>
                <p class="advice-number">Digite apenas números</p>
                @error('number')
                    <p class="error-name-lenght">Número inválido, o número deve ter 11 caracteres, sem "-" ou parênteses</p>
                @enderror
                        
                <h3 class="login-input">Responsável:*</h3>
                <input class="input" name="responsible" type="text" placeholder="Insira o nome do responsável" required>

                <h3 class="login-input">Número de celular do responsável:*</h3>
                <input class="input" name="responsible_number" type="number" placeholder="Insira número de celular aqui" required>
                <p class="advice-number">Digite apenas números</p>
                @error('number')
                    <p class="error-name-lenght">Número inválido, o número deve ter 11 caracteres, sem "-" ou parênteses</p>
                @enderror
             
                

                <br>
                <button linkto="{{ route('cadastrar-aluno') }}" type="submit" class="login-btn">Cadastrar aluno</button>
            </form>
        </div>
    </section>

@endsection