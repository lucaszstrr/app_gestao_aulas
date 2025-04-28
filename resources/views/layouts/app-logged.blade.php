<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reforçando</title>

        <link rel="shortcut icon" href="{{ asset('imgs/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('imgs/favicon.ico') }}" type="image/x-icon">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        
    </head>
    <body>
        @include('components.auth-header')

        @yield('content', 'Nenhum conteúdo renderizado!')
    </body>
</html>