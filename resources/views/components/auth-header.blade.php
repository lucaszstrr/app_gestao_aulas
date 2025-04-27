<header>
    <div class="header_left">
        <a href="{{ route('home') }}">
            <img src="{{asset('imgs/logo-reforcando.png')}}" alt="Reforçando">
        </a>
    </div>

    <!-- Menu do meio (transformado em hambúrguer no mobile) -->
    <div class="header_middle">
        <!-- Checkbox invisível para controlar o menu -->
        <input type="checkbox" id="menu-toggle" class="menu-toggle" />
        
        <!-- Ícone do hambúrguer (aparece só no mobile) -->
        <label for="menu-toggle" class="hamburguer">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        
        <!-- Links do menu (ocultos no mobile até clicar) -->
        <nav class="nav-middle">
            <a href="{{ route('meus-alunos') }}">Meus Alunos</a>
            <a href="{{ route('menu-professor') }}">Menu do Professor</a>
            <a href="">Finanças</a>
        </nav>
    </div>

    <div class="header_right">
        <a href="" class="logged-header">  
            @auth
            Olá, {{ explode(' ', auth()->user()->name)[0] }}!
            @endauth
        </a>
        <a href="{{ route('logout') }}"><button class="btn_login">Sair</button></a>    
    </div>
</header>