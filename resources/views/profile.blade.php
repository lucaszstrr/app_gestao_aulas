@extends('layouts.app-logged')

@section('content')

    <div class="content-profile-page">
        <h1>Meu perfil</h1>
        <h3 class="profile-greet">{{ $greet }}, {{ $firstName }}!</h3>
        <div class="content-grid">

            <div class="profile-data">

                <form class="profile-data-form" method="POST" action="{{ route('atualizar-nome') }}">
                    @csrf
                    @method('PUT')

                    <h3 class="login-input">Nome:</h3>
                    <input type="text" class="input" name="name" placeholder="Insira o nome aqui" value="{{ $userName }}" nullable>

                    <h3 class="login-input">Formação:</h3>
                    <input type="text" class="input" name="area" placeholder="Insira sua formação aqui" value="{{ $userLogged->area }}" nullable>

                    <br>
                    <button class="green-button" linkto="{{ route('atualizar-nome') }}">Atualizar dados</button>
                    <br>
                    @error('name-lenght')
                        <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Nome inválido</p>
                    @enderror
                    @error('area-lenght')
                        <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Formação inválida</p>
                    @enderror
                    @error('empty-spaces')
                        <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Dados inválidos</p>
                    @enderror

                    @if (session('success'))
                        <p class="success-message"><i class="fa-solid fa-check" style="color: #3a6604;"></i> Dados atualizados com sucesso!</p>
                    @endif
                </form>
                
            </div>

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
                    
                    @if (session('success-key'))
                        <p class="success-message"><i class="fa-solid fa-check" style="color: #3a6604;"></i> Chave cadastrada com sucesso!</p>
                    @endif
                    <br>
                    <button class="green-button" linkto="{{ route('adicionar-chave-pix') }}">Atualizar Chave</button>
                    <br>
                    
                </form>
            </div>
            
            <div class="profile-data">
                <form class="profile-data-form" method="POST" action="{{ route('mudar-senha') }}">
                    @csrf
                    @method('PUT')
                    <h3 class="login-input">Senha:</h3>
                    <input type="password" class="input" name="password" placeholder="Insira sua senha atual aqui" nullable>

                    <h3 class="login-input">Nova senha:</h3>
                    <input type="password" class="input" name="new_password" placeholder="Insira sua nova senha aqui" nullable>

                    <br>
                    <button class="green-button" linkto="{{ route('mudar-senha') }}">Mudar senha</button>
                    <br>

                    @error('incorrect-password')
                        <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Senha atual incorreta</p>
                    @enderror

                    @error('password-lenght')
                        <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> A senha deve ter no mínimo 7 caracteres</p>
                    @enderror

                    @if (session('new-password'))
                        <p class="success-message"><i class="fa-solid fa-check" style="color: #3a6604;"></i> Senha atualizada com sucesso!</p>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection