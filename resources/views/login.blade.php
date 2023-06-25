<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="h-screen bg-gray-400 flex flex-col items-center justify-center">
    @if(session()->has('success'))
    <div class="bg-green-300 text-green-500 border-2 border-green-500 border-r-2 p-4 mb-4 font-semibold">
        {{session()->get('success')}}
    </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-300 text-red-500 border-2 border-red-500 border-r-2 p-4 mb-4 font-semibold">
            {{session()->get('error')}}
        </div>
    @endif
    <div class="flex flex-col border-2 p-4 rounded-sm">
        <div class="text-center text-xl font-bold">
            Inicia sesión
        </div>
        <form class="flex flex-col mt-4" action="/" method="POST">
            @csrf
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password">
            <button type="submit" class="rounded-sm bg-white mt-2">
                Acceder
            </button>
        </form>
    </div>
    <div class="text-center mt-4">
        ¿Aún no tienes acceso? <a href="/register" class="underline">Regístrate aquí</a>
    </div>

    </body>
</html>
