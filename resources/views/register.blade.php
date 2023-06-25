<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script>
            function validateForm(){

                document.getElementById('alert').style.display = 'none';
                document.getElementById('alertText').innerHTML = '';

                let username = document.getElementById('username').value;
                let password = document.getElementById('password').value;
                let passwordConf = document.getElementById('passwordConf').value;

                var errMsg = '';

                if(password !== passwordConf){
                    errMsg = 'Las contraseñas no coinciden';
                }

                if(/\s/g.test(username)){
                    errMsg = 'El nombre de usuario no puede contener espacios en blanco';
                }

                if(password.length < 8){
                    errMsg = 'La contraseña debe tener al menos 8 caracteres'
                }

                if(username.length < 4){
                    errMsg = 'El nombre de usuario debe tener al menos 4 caracteres';
                }

                if(username === ''){
                    errMsg = 'El nombre de usuario no puede estar vacío';
                }

                if(errMsg !== ''){
                    showAlert(errMsg);
                }else{
                    checkUsernameAvailability(username);
                }


            }

            function showAlert(msg){
                document.getElementById('alertText').innerHTML = msg;
                document.getElementById('alert').style.display = '';
            }

            function checkUsernameAvailability(username){
                var url = '/check-username/' + username;
                var opciones = {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                };
                var request = new Request(url, opciones);

                fetch(request)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(datos) {
                        console.log(datos)
                        if(datos === 'OK'){
                            document.getElementById('form').submit();
                        }else{
                            showAlert('El nombre de usuario ya está registrado');
                        }
                    })
                    .catch(function(error) {
                        return 'FAILED';
                    });

            }

        </script>
    </head>
    <body class="h-screen bg-gray-400 flex flex-col items-center justify-center">
    <div id="alert" class="bg-red-300 text-red-500 border-2 border-red-500 border-r-2 p-4 mb-4 font-semibold" style="display: none">
        <span id="alertText">El nombre de usuario no puede contener espacios</span>
    </div>
    <div class="flex flex-col border-2 p-4 rounded-sm">
        <div class="text-center text-xl font-bold">
            Introduce los datos solicitados
        </div>
        <form id="form" class="flex flex-col mt-4" action="/register" method="POST">
            @csrf
            <label for="username">Tu nombre de usuario</label>
            <input type="text" name="username" id="username">
            <label for="password">Tu contraseña</label>
            <input type="password" name="password" id="password" minlength="8">
            <label for="passwordConf">Confirma tu contraseña</label>
            <input type="password" name="passwordConf" id="passwordConf" minlength="8">
            <button type="button" onclick="validateForm()" class="rounded-sm bg-white mt-4 w-48">
                Regístrate
            </button>
        </form>
    </div>
    <div class="text-center mt-4">
        <a href="/" class="underline">Volver al login</a>
    </div>

    </body>
</html>
