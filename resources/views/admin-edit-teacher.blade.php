@extends('layouts.app-admin')

@section('content')
    <a href="{{ route('admin-professor') }}" class="return-back-link"><- Voltar</a>
    <section class="main-content">
        <div class="register-student">
            <h2 class="text-login">Editar professor</h2>
            <form method="POST" action="{{ route('submit-editar-professor', $teacher->id) }}">
                @csrf
                @method('PUT')
                <h3 class="login-input">Nome:</h3>
                <input class="input" name="name" type="text" placeholder="Insira o nome aqui" value="{{ $teacher->name }}" required>
                @error('name-lenght')
                    <p class="error-name-lenght">O nome deve ter mais caracteres</p>
                @enderror
                        
                <h3 class="login-input">Email:</h3>
                <input class="input" name="email" type="text" placeholder="Insira o email aqui" value="{{ $teacher->email }}" nullable>
                             
                <h3 class="login-input">Formação:</h3>
                <input class="input" name="area" type="text" placeholder="Insira a formação aqui" value="{{ $teacher->area }}" nullable>
                 @error('area-lenght')
                    <p class="error-name-lenght">Este campo deve ter mais caracteres</p>
                @enderror

                <br>
                <button linkto="{{ route('submit-editar-professor', $teacher->id) }}" type="submit" class="login-btn">Confirmar alterações</button>
            </form>
        </div>
    </section>

@endsection