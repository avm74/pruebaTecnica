<?php

namespace App\Http\Helpers;

use App\Models\Achievement;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use stdClass;

class Functions extends Controller
{
   public function stringIsEmpty($str){

       if(is_null($str) || trim($str) == '' || ctype_space(trim($str))){
           return true;
       }

       return false;
   }

   public function sanitizeString($str){

       return filter_var(trim($str), FILTER_SANITIZE_STRING);

   }

}
