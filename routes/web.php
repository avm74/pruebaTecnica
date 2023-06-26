<?php

use App\Http\Controllers\CreateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReturnDocumentsController;
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

// Crear documento
Route::get('/create', [CreateController::class, 'getCreate']);
Route::post('/create', [CreateController::class, 'postCreate']);

// Editar documento
Route::get('/edit/{documentId}', [EditController::class, 'getEdit']);
Route::post('/edit/{documentId}', [EditController::class, 'postEdit']);

// Eliminar documento
Route::get('/delete/{documentId}', [DeleteController::class, 'getDelete']);

// Peticiones
Route::get('/check-username/{username}', [RegisterController::class, 'checkUsernameAvailability']);

// Endpoint para devolver todos los documentos agrupados por relevancia
Route::get('/get-documents/{relevance}', [ReturnDocumentsController::class, 'getDocuments']);
