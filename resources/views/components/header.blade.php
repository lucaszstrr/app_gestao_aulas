<header>

    <div class="header_left">
        <a href="{{ route('home') }}">
            <img src="{{asset("imgs/logo-reforcando.png")}}" alt="Reforçando">
        </a>
        

    </div>

    <div class="header_right">

        <a href="{{route('register')}}"><button>Criar Conta</button></a>
        <a href="{{route('login')}}"><button class="btn_login">Login</button></a>
        <!--
        @include('components.button',['text' => 'Criar Conta','class' => '', 'href' => "{{route('createaccount')}}"])
        @include('components.button',['text' => 'Login','class' => 'btn_login'])
        -->
    </div>
    
</header>