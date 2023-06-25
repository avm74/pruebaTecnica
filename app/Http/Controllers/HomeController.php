<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Functions;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class HomeController extends Controller
{
    public function getHome(Request $request){

        if(!$request->session()->has('username')){
            return redirect()->action([LoginController::class, 'getLogin']);
        }

        $user = User::where('username', '=', session('username'))->first();

        if(!$user){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "Login no válido");
        }

        $documents = Document::where('user_id', '=', $user->id)->get();

        $viewData = [
            'connectedUser' => $user,
            'documents' => $documents
        ];

        return view('home', $viewData);

    }

    public function logout(Request $request){

        if($request->session()->has('username')){
            $request->session()->forget('username');
        }

        return redirect()->action([LoginController::class, 'getLogin'])->with("success", "Sesión cerrada");
    }

    public function createDocument(Request $request, Functions $helper){

        $user = User::where('username', '=', session('username'))->first();

        if(!$user){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "No hay una sesión activa");
        }

        $name = $helper->sanitizeString($request->input('name'));
        $description = $helper->sanitizeString($request->input('description'));
        $relevance = $helper->sanitizeString($request->input('relevance'));

        if($helper->stringIsEmpty($name) || $helper->stringIsEmpty($description) || $helper->stringIsEmpty($relevance)){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Datos de documento inválidos");
        }

        if($relevance != 'Alta' && $relevance!= 'Media' && $relevance != 'Baja'){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Relevanca no válida");
        }

        $newDocument = new Document();

        $newDocument->user_id = $user->id;
        $newDocument->name = $name;
        $newDocument->description = $description;
        $newDocument->relevance = $relevance;

        $newDocument->save();

        return redirect()->action([HomeController::class, 'getHome'])->with("success", "Documento creado con éxito");

    }

    public function deleteDocument($documentId){

        $document = Document::find($documentId);

        if(!$document){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Error en el borrado");
        }

        $document->delete();

        return redirect()->action([HomeController::class, 'getHome'])->with("success", "Documento eliminado con éxito");

    }
}
