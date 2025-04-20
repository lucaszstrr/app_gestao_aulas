<header>

    <div class="header_left">
        <a href="{{ route('home') }}">
            <img src="{{asset("imgs/logo-reforcando.png")}}" alt="Reforçando">
        </a>
        

    </div>

    <div class="header_right">

        <button><a href="{{route('register')}}">Criar Conta</a></button>
        <button class="btn_login"><a href="{{route('login')}}">Login</a></button>
        <!--
        @include('components.button',['text' => 'Criar Conta','class' => '', 'href' => "{{route('createaccount')}}"])
        @include('components.button',['text' => 'Login','class' => 'btn_login'])
        -->
    </div>
    
</header>