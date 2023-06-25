<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getLogin(Request $request){

        $viewData = [

        ];

        if($request->session()->has('username')){
            return redirect()->action([HomeController::class, 'getHome']);
        }

        return view('login', $viewData);

    }

    public function postLogin(Request $request){

        $username = $request->input('username');
        $password = $request->input('password');

        $userEncontrado = User::where('username', '=', $username)->first();

        if(!$userEncontrado){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "Usuario no encontrado");
        }

        if(!Hash::check($password, $userEncontrado->password)){
            return redirect()->action([LoginController::class, 'getLogin'])->with("error", "Contraseña incorrecta");
        }

        // Iniciar sesion
        $request->session()->put('username',$userEncontrado->username);

        return redirect()->action([HomeController::class, 'getHome']);

    }
}
