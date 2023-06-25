<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getLogin(Request $request){

        $viewData = [

        ];

        return view('login', $viewData);

    }

    public function postLogin(Request $request){



    }
}
