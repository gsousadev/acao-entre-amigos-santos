<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Services\SorteioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SorteioController extends Controller
{

   public function __construct(private SorteioService $sorteioService){
   }

    public function limpar()
    {
        Sorteio::query()->delete();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Limpeza de sorteios feita com sucesso", 'tipo' => "success"]]);
    }

    public function raffle(Request $request)
    {
        $quantidadeNumeros = $request->get('quantidade_numeros_sorteio');
        $bilhetesValidados = $this->sorteioService->buscarBilhetesDisponiveisSorteio();

        if($quantidadeNumeros > $bilhetesValidados->count()){
            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Não há bilhetes validos disponíveis para esse sorteio", 'tipo' => "error"]]);
        }


        $bilheteSorteado = $bilhetesValidados->shuffle()->first();
        $bilheteSorteado->sorteios()->save(new Sorteio());
        $bilhetesValidados->forget($bilheteSorteado)

        dd($bilheteSorteado, $bilhetesValidados);


        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Sorteio Realizado!", 'tipo' => "success"]]);
    }
}
