<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\SorteioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'show']);

Route::post('/bilhete', [BilheteController::class, 'create']);
Route::post('/bilhete/validar', [BilheteController::class, 'markValidateTrue']);
Route::post('/bilhete/invalidar', [BilheteController::class, 'markValidateFalse']);
Route::post('/bilhete/deletar', [BilheteController::class, 'delete']);
Route::post('/sorteio/sortear', [SorteioController::class, 'raffle']);
Route::post('/sorteio/limpar', [SorteioController::class, 'limpar']);



Route::get('/login', [Controller::class, 'loginView'])->name('loginView');
Route::post('/login', [Controller::class, 'loginPerform'])->name('loginPerform');
Route::get('/admin', [AdminController::class, 'adminView']);
Route::get('/logout', [Controller::class, 'logout']);
