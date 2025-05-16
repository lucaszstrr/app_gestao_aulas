@extends('layouts.app-logged')

@section('content')

    <div class="content-profile-page">
        <h1>Meu perfil</h1>
        <h3>{{ $greet }}, {{ $firstName }}!</h3>
        
        <div class="profile-data">

            @if($user['pix-key'] == null)
                <p>Você ainda não tem uma chave PIX cadastrada</p>
            @else
                <p>Sua chave PIX atual é:</p>
                <p class="user-pix-key">{{ $user['pix-key'] }}</p>
            @endif

            <form class="profile-data-form" method="POST" action="{{ route('adicionar-chave-pix') }}">
                @csrf
                @method('POST')

                <h3 class="login-input">Chave PIX:</h3>
                <input type="text" class="input" name="pix-key" placeholder="Insira aqui a sua chave" required>

                <h3 class="login-input">Tipo da Chave:</h3>
                <select class="input" name="pix-key-type" required>
                    <option class="input-option" value="cpf">CPF</option>
                    <option class="input-option" value="cnpj">CNPJ</option>
                    <option class="input-option" value="number">Telefone</option>
                    <option class="input-option" value="email">Email</option>
                    <option class="input-option" value="random">Chave Aleatória</option>
                </select>

                @error('cpf-key-size')
                     <p class="field-error">O CPF deve ter 11 caracteres</p>
                @enderror

                @error('number-key-size')
                     <p class="field-error">O número deve ter 11 caracteres</p>
                @enderror

                @error('cnpj-key-size')
                     <p class="field-error">O CNPJ deve ter 14 caracteres</p>
                @enderror

                @error('random-key-size')
                     <p class="field-error">A chave deve ter 32 caracteres</p>
                @enderror

                <h3>Insira corretamente a sua chave!</h3>
                <br>
                <button class="green-button" linkto="{{ route('adicionar-chave-pix') }}">Atualizar Chave</button>
                <br>
            </form>
        </div>
    </div>

@endsection