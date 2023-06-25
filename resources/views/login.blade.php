<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="h-screen bg-gray-400 flex items-center justify-center">
    <div class="flex flex-col border-2 p-4 rounded-sm">
        <div class="text-center text-xl font-bold">
            Inicia sesión
        </div>
        <form class="flex flex-col mt-4">
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password">
            <button class="rounded-sm bg-white mt-2">
                Save Changes
            </button>
        </form>
    </div>

    </body>
</html>
