<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login
Route::get('/', [LoginController::class, 'getLogin']);
Route::post('/', [LoginController::class, 'postLogin']);

// Register
Route::get('/register', [RegisterController::class, 'getRegister']);
Route::post('/register', [RegisterController::class, 'postRegister']);

// Home
Route::get('/home', [HomeController::class, 'getHome']);
Route::get('/logout', [HomeController::class, 'logout']);

// Peticiones
Route::get('/check-username/{username}', [RegisterController::class, 'checkUsernameAvailability']);
