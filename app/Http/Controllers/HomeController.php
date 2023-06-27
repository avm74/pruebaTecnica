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
            'documents' => $documents,
            'filter' => ''
        ];

        return view('home', $viewData);

    }

    public function postHome(Request $request, Functions $helper){

        if(!$request->session()->has('username')){
            return redirect()->action([LoginController::class, 'getLogin']);
        }

        $user = User::where('username', '=', session('username'))->first();

        if(!$user){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "Login no válido");
        }

        $filter = $helper->sanitizeString($request->input('relevanceFilter'));

        $documents = Document::where('user_id', '=', $user->id)->get();

        if($filter != ''){

            switch ($filter){
                case 'Alta':
                    $documents = Document::where('user_id', '=', $user->id)->where('relevance', '=', 'Alta')->get();
                    break;
                case 'Media':
                    $documents = Document::where('user_id', '=', $user->id)->where('relevance', '=', 'Media')->get();
                    break;
                case 'Baja':
                    $documents = Document::where('user_id', '=', $user->id)->where('relevance', '=', 'Baja')->get();
                    break;
            }

        }

        $viewData = [
            'connectedUser' => $user,
            'documents' => $documents,
            'filter' => $filter
        ];

        return view('home', $viewData);

    }

    public function logout(Request $request){

        if($request->session()->has('username')){
            $request->session()->forget('username');
            return redirect()->action([LoginController::class, 'getLogin'])->with("success", "Sesión cerrada");
        }

        return redirect()->action([LoginController::class, 'getLogin'])->with("error", "No había una sesión iniciada");
    }
}
