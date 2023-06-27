<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Functions;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class EditController extends Controller
{
    public function getEdit($documentId, Request $request){

        if(!$request->session()->has('username')){
            return redirect()->action([LoginController::class, 'getLogin']);
        }

        $document = Document::find($documentId);
        $user = User::where('username', '=', session('username'))->first();

        if(!$user){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "Login no válido");
        }

        if(!$document || $document->user_id != $user->id){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Documento no encontrado");
        }

        $viewData = [
            'document' => $document
        ];

        return view('edit', $viewData);

    }

    public function postEdit($documentId, Request $request, Functions $helper){

        $document = Document::find($documentId);

        if(!$document){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Documento no encontrado");
        }

        $name = $helper->sanitizeString($request->input('name'));
        $description = $helper->sanitizeString($request->input('description'));
        $relevance = $helper->sanitizeString($request->input('relevance'));

        if(empty($name)){
            return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("error", "El nombre del documento no puede estar vacío");
        }

        if(empty($description)){
            return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("error", "La descripcióndel documento no puede estar vacía");
        }

        if(empty($relevance)){
            return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("error", "Debes elegir una categoría de relevancia");
        }

        if(strlen($name) > 30){
            return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("error", "El nombre del documento no puede tener más de 30 caracteres");
        }

        if(strlen($description) > 300){
            return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("error", "La descripción del documento no puede tener más de 300 caracteres");
        }

        $document->name = $name;
        $document->description = $description;
        $document->relevance = $relevance;

        $document->save();

        return redirect()->action([EditController::class, 'getEdit'], ['documentId' => $document->id])->with("success", "Documento editado correctamente");
    }
}
