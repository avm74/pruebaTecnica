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

                let name = document.getElementById('name').value;
                let description = document.getElementById('description').value;
                let relevance = document.getElementById('relevance').value;

                var errMsg = '';

                if(name.length > 30){
                    errMsg = 'El nombre del documento no puede tener más de 30 caracteres';
                }

                if(name.length > 300){
                    errMsg = 'La descripción del documento no puede tener más de 300 caracteres';
                }

                if(name === ''){
                    errMsg = 'El nombre del documento no puede estar vacío';
                }

                if(description === ''){
                    errMsg = 'La descripción del documento no puede estar vacía';
                }

                if(relevance === ''){
                    errMsg = 'Debes elegir una categoría de relevancia';
                }

                if(errMsg !== ''){
                    showAlert(errMsg);
                }else{
                    document.getElementById('form').submit();
                }

            }

            function showAlert(msg){
                document.getElementById('alertText').innerHTML = msg;
                document.getElementById('alert').style.display = '';
            }
        </script>
    </head>
    <div class="flex flex-row justify-center items-center bg-gray-100 w-full h-10 absolute top-0">
        <div class="mr-2 font-semibold text-lg hover:text-gray-400">
            <a href="/home">Documentos</a>
        </div>
        <div class="ml-2 font-semibold text-lg hover:text-gray-400">
            <a href="/logout">Cerrar sesión</a>
        </div>
    </div>
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
        <div id="alert" class="bg-red-300 text-red-500 border-2 border-red-500 border-r-2 p-4 mb-4 font-semibold" style="display: none">
            <span id="alertText"></span>
        </div>
        <form id="form" action="/edit/{{$document->id}}" method="POST" class="flex flex-col">
            @csrf
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{$document->name}}" maxlength="30" placeholder="Introduce el nombre del documento">
            <label for="relevance">Relevancia</label>
            <select id="relevance" name="relevance">
                <option value="Alta" @if($document->relevance == 'Alta') selected @endif>Alta</option>
                <option value="Media" @if($document->relevance == 'Media') selected @endif>Media</option>
                <option value="Baja" @if($document->relevance == 'Baja') selected @endif>Baja</option>
            </select>
            <label for="description">Descripción</label>
            <textarea id="description" name="description" cols="100" rows="6" maxlength="300" placeholder="Introduce una descripción del documento">{{$document->description}}</textarea>
            <button type="button" onclick="validateForm()" class="rounded-sm bg-white mt-2 w-48 text-center">
                Guardar cambios
            </button>
        </form>
    </body>
</html>
