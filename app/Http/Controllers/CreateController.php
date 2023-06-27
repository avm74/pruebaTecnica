<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Functions;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class CreateController extends Controller
{
    public function getCreate(Request $request){

        if(!$request->session()->has('username')){
            return redirect()->action([LoginController::class, 'getLogin']);
        }

        $viewData = [

        ];

        return view('create', $viewData);

    }

    public function postCreate(Request $request, Functions $helper){

        $user = User::where('username', '=', session('username'))->first();

        if(!$user){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "No hay una sesión activa");
        }

        $name = $helper->sanitizeString($request->input('name'));
        $description = $helper->sanitizeString($request->input('description'));
        $relevance = $helper->sanitizeString($request->input('relevance'));

        if(empty($name)){
            return redirect()->action([CreateController::class, 'getCreate'])->with("error", "El nombre del documento no puede estar vacío");
        }

        if(empty($description)){
            return redirect()->action([CreateController::class, 'getCreate'])->with("error", "La descripción no puede estar vacía");
        }

        if(empty($relevance)){
            return redirect()->action([CreateController::class, 'getCreate'])->with("error", "Debes elegir una categoría de relevancia");
        }

        if(strlen($name) > 30){
            return redirect()->action([CreateController::class, 'getCreate'])->with("error", "El nombre del documento no puede tener más de 30 caracteres");
        }

        if(strlen($description) > 300){
            return redirect()->action([CreateController::class, 'getCreate'])->with("error", "La descripción del documento no puede tener más de 300 caracteres");
        }

        $newDocument = new Document();

        $newDocument->user_id = $user->id;
        $newDocument->name = $name;
        $newDocument->description = $description;
        $newDocument->relevance = $relevance;

        $newDocument->save();

        return redirect()->action([HomeController::class, 'getHome'])->with("success", "Documento creado correctamente");
    }
}
