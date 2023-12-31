<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script>
            function goToDelete(documentId){
                window.location = "/delete/" + documentId;
            }

            function goToEdit(documentId){
                window.location = "/edit/" + documentId;
            }

            function goToCreate(){
                window.location = "/create";
            }

            function filterList(){
                document.getElementById('form').submit();
            }
        </script>
    </head>
    <body class="h-screen bg-gray-400 flex flex-col items-center justify-center">
        <div class="flex flex-row justify-center items-center bg-gray-100 w-full h-10 absolute top-0">
            <div class="ml-2 font-semibold text-lg hover:text-gray-400">
                <a href="/logout">
                    Cerrar sesión
                </a>
            </div>
        </div>

        <div class="text-center mb-8 flex flex-col">
            <span class="font-bold text-lg">Bienvenido a tu listado de documentos</span>
            <span>Has iniciado sesión como <span class="font-semibold">{{$connectedUser->username}}</span></span>
        </div>

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

        <div>
            <button type="button" onclick="goToCreate()" class="rounded-sm bg-white w-48 text-center">
                Crear nuevo documento
            </button>
        </div>


        <div id="documentList" class="border-2 p-4 mt-4 max-w-6xl">
            @if(count($documents) < 1)
                <span class="font-semibold">No hay documentos disponibles</span>
                <div>
                    <form action="/home" method="POST" id="form">
                        @csrf
                        <label for="relevanceFilter">Prueba con otro tipo de relevancia</label>
                        <select id="relevanceFilter" name="relevanceFilter" onchange="filterList()" class="font-normal">
                            <option value="" @if($filter == '' || !isset($filter)) selected @endif>
                                Todas
                            </option>
                            <option value="Alta" @if($filter == 'Alta') selected @endif>
                                Alta
                            </option>
                            <option value="Media" @if($filter == 'Media') selected @endif>
                                Media
                            </option>
                            <option value="Baja" @if($filter == 'Baja') selected @endif>
                                Baja
                            </option>
                        </select>
                    </form>
                </div>
            @else
                <table>
                    <tr class="border-2 p-4 mt-4">
                        <th class="border-2 p-2">
                            ID del documento
                        </th>
                        <th class="border-2 p-2">
                            Nombre
                        </th>
                        <th class="border-2 p-2">
                            Descripción
                        </th>
                        <th class="border-2 p-2">
                            Relevancia
                            <form action="/home" method="POST" id="form">
                                @csrf
                                <select id="relevanceFilter" name="relevanceFilter" onchange="filterList()" class="font-normal">
                                    <option value="" @if($filter == '' || !isset($filter)) selected @endif>
                                        Todas
                                    </option>
                                    <option value="Alta" @if($filter == 'Alta') selected @endif>
                                        Alta
                                    </option>
                                    <option value="Media" @if($filter == 'Media') selected @endif>
                                        Media
                                    </option>
                                    <option value="Baja" @if($filter == 'Baja') selected @endif>
                                        Baja
                                    </option>
                                </select>
                            </form>

                        </th>
                        <th class="border-2 p-2">
                            Última edición
                        </th>
                        <th class="border-2 p-2">
                            Acciones
                        </th>
                    </tr>
                    @foreach($documents as $document)
                        <tr id="doc{{$document->id}}" class="border-2 p-4 mt-4 text-center">
                            <td class="border-2 p-2">
                                {{$document->id}}
                            </td>
                            <td class="border-2 p-2">
                                {{$document->name}}
                            </td>
                            <td class="border-2 p-2">
                                {{$document->description}}
                            </td>
                            <td class="border-2 p-2">
                                {{$document->relevance}}
                            </td>
                            <td class="border-2 p-2">
                                {{$document->updated_at}}
                            </td>
                            <td class="border-1 p-2 ml-auto">
                                <button type="button" class="rounded-sm mt-2" onclick="goToDelete('{{$document->id}}')"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></button>
                                <button type="button" class="rounded-sm mt-2" onclick="goToEdit('{{$document->id}}')"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg></button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </body>
</html>
