<header>

    <div class="header_left">
    
        <img href="{{asset("imgs/logo-financas.png")}}" alt="Reforçando">

    </div>

    <div class="header_right">

        @include('components.button',['text' => 'Criar Conta','class' => ''])
        @include('components.button',['text' => 'Login','class' => 'btn_login'])

    </div>
    
</header>