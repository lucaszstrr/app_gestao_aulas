<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reforçando</title>

        <link rel="shortcut icon" href="{{ asset('imgs/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('imgs/favicon.ico') }}" type="image/x-icon">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        
    </head>
    <body>
        @include('components.header')

        @yield('content', 'Nenhum conteúdo renderizado!')
    </body>
</html>