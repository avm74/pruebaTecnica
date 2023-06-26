<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Functions;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class DeleteController extends Controller
{
    public function getDelete($documentId){

        $document = Document::find($documentId);

        if(!$document){
            return redirect()->action([HomeController::class, 'getHome'])->with("error", "Error en el borrado");
        }

        $document->delete();

        return redirect()->action([HomeController::class, 'getHome'])->with("success", "Documento eliminado con éxito");

    }
}
