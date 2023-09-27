<?php

use App\Http\Controllers\AdminController;
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
Route::post('/bilhete/reenviar-email', [BilheteController::class, 'reenviarEmail']);
Route::post('/sorteio/sortear', [SorteioController::class, 'raffle']);
Route::post('/sorteio/limpar', [SorteioController::class, 'limpar']);



Route::get('/login', [AdminController::class, 'loginView'])->name('loginView');
Route::post('/login', [AdminController::class, 'loginPerform'])->name('loginPerform');
Route::get('/admin', [AdminController::class, 'adminView']);
Route::get('/logout', [AdminController::class, 'logout']);

Route::get('/email_bilhete', function(){
    return view('email_bilhete_cadastrada', [
        'bilhete' => [
           'id' => '1',
            'nome_convidado' => 'Guilherme Santos',
            'email_convidado' => 'guilherme.santos@email.com',
            'telefone_convidado' => '(11) 98766-2763',
            'validada' => true,
            'santo' => [
                'nome' => 'Santo Antônio',
                'id' => '1'
            ],
            'created_at' => '20/05/23 16:29:07',
        ]
    ]);
});
