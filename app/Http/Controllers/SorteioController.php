<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Sorteio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class SorteioController extends Controller
{
    public function limpar()
    {
        Sorteio::query()->delete();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Limpeza de sorteios feita com sucesso", 'tipo' => "success"]]);
    }
}
