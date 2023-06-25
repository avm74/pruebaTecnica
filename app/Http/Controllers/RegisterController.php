<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\Functions;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function getRegister(Request $request){

        $viewData = [

        ];

        return view('register', $viewData);

    }

    public function postRegister(Request $request, Functions $helper){

        $username = $helper->sanitizeString($request->input('username'));
        $password = $helper->sanitizeString($request->input('password'));
        $passwordConf = $helper->sanitizeString($request->input('passwordConf'));

        $userFound = User::where('username', '=', $username)->first();

        if($userFound){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if($password !== $passwordConf){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if(strlen($username) < 4){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if(strlen($password) < 8){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if(empty($username)){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if(empty($password)){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        if(empty($passwordConf)){
            return redirect()->action([RegisterController::class, 'getRegister'])->with("error", "Registro incorrecto");
        }

        $newUser = new User();

        $newUser->username = $username;
        $newUser->password = Hash::make($password);

        $newUser->save();

        return redirect()->action([LoginController::class, 'getLogin'])->with("success", "Te has registrado correctamente");

    }

    public function checkUsernameAvailability($username){

        $userFound = User::where('username', '=', $username)->first();

        if($userFound){
            return response()->json("ERR");
        }

        return response()->json("OK");



    }
}
