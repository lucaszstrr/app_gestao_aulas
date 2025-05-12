@extends('layouts.app-logged')

@section('content')
    <a href="{{ route('meus-alunos') }}" class="return-back-link"><- Voltar</a>
    <section class="main-content">
        <div class="register-student">
            <h2 class="text-login">Editar aluno</h2>
            <form method="POST" action="{{ route('submit-editar-aluno', $student->id) }}">
                @csrf
                @method('PUT')
                <h3 class="login-input">Nome:*</h3>
                <input class="input" name="name" type="text" placeholder="Insira o nome aqui" value="{{ $student->name }}" required>
                        
                <h3 class="login-input">Idade:</h3>
                <input class="input" name="age" type="number" placeholder="Insira a idade aqui" value="{{ $student->age }}" nullable>
                        
                <h3 class="login-input">Nível Escolar:*</h3>
                <select class="input" name="school_year" required>
                    <option class="input-option" value="fundamental 1" {{ old('school_year', $student->school_year) == 'fundamental 1' ? 'selected' : '' }}>Fundamental 1</option>
                    <option class="input-option" value="fundamental 2" {{ old('school_year', $student->school_year) == 'fundamental 2' ? 'selected' : '' }}>Fundamental 2</option>
                    <option class="input-option" value="ensino médio" {{ old('school_year', $student->school_year) == 'ensino médio' ? 'selected' : '' }}>Ensino Médio</option>
                    <option class="input-option" value="ensino superior" {{ old('school_year', $student->school_year) == 'ensino superior' ? 'selected' : '' }}>Ensino Superior</option>
                </select>
                        
                <h3 class="login-input">Escola:</h3>
                <input class="input" name="school" type="text" placeholder="Insira a escola aqui" value="{{ $student->school }}" nullable>
                        
                <h3 class="login-input">Número de celular:</h3>
                <input class="input" name="number" type="number" placeholder="Insira número de celular aqui" value="{{ $student->number }}" nullable>
                <p class="advice-number">Digite apenas números</p>
                @error('number')
                    <p class="error-name-lenght">Número inválido, o número deve ter 11 caracteres, sem "-" ou parênteses</p>
                @enderror
                        
                <h3 class="login-input">Responsável:*</h3>
                <input class="input" name="responsible" type="text" placeholder="Insira o nome do responsável" value="{{ $student->responsible }}" required>

                <h3 class="login-input">Número de celular do responsável:*</h3>
                <input class="input" name="responsible_number" type="number" placeholder="Insira número de celular aqui" value="{{ $responsible->number }}" required>
                <p class="advice-number">Digite apenas números</p>
                @error('number')
                    <p class="error-name-lenght">Número inválido, o número deve ter 11 caracteres, sem "-" ou parênteses</p>
                @enderror
             
                <br>
                <button linkto="{{ route('submit-editar-aluno', $student->id) }}" type="submit" class="login-btn">Confirmar alterações</button>
            </form>
        </div>
    </section>

@endsection