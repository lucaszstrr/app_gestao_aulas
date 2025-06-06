<header>
    <div class="header_left">
        <a href="{{ route('meus-alunos') }}">
            <img src="{{asset('imgs/logo-reforcando.png')}}" alt="Reforçando">
        </a>
    </div>

    <div class="header_middle">
        <input type="checkbox" id="menu-toggle" class="menu-toggle" />
        
        <label for="menu-toggle" class="hamburguer">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        
        <nav class="nav-middle">
            <a href="{{ route('meus-alunos') }}">Meus Alunos</a>
            <a href="{{ route('menu-professor') }}">Menu do Professor</a>
            <a href="{{ route('financas') }}">Finanças</a>
            <a href="{{ route('perfil') }}">Meu perfil</a>
            <a href="{{ route('logout') }}"><button class="btn_login">Sair <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i></button></a>
        </nav>
    </div>

    <div class="header_right">
        <a href="{{ route('perfil') }}" class="logged-header">  
            @auth
            Olá, {{ explode(' ', auth()->user()->name)[0] }}! <i class="fa-solid fa-circle-user fa-xl" style="color: #6e6e6e;"></i>
            @endauth
        </a> 
    </div>
</header>