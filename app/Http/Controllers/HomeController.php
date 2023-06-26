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
}
