<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="h-screen bg-gray-400 flex flex-col items-center justify-center">
        ¡Bienvenido {{$connectedUser->username}}!
        <div>
            <a href="/logout">Cerrar sesión</a>
        </div>
    </body>
</html>
