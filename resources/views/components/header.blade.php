<header>

    <div class="header_left">
    
        <img href="{{asset("imgs/logo-reforcando.png")}}" alt="Reforçando">

    </div>

    <div class="header_right">

        @include('components.button',['text' => 'Criar Conta','class' => '', 'href' => 'createaccount'])
        @include('components.button',['text' => 'Login','class' => 'btn_login'])

    </div>
    
</header>