<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Services\SorteioService;
use Illuminate\Http\Request;

class SorteioController extends Controller
{

    public function __construct(private SorteioService $sorteioService)
    {
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

        if ($quantidadeNumeros > $bilhetesValidados->count()) {
            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Não há bilhetes validos disponíveis para esse sorteio", 'tipo' => "danger"]]);
        }

        $bilheteSorteados = $bilhetesValidados->shuffle()->random($quantidadeNumeros);


        $bilheteSorteados->each(function (Bilhete $bilheteSorteado) {
            $bilheteSorteado->sorteios()->save(new Sorteio());
        });

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Sorteio Realizado!", 'tipo' => "success"]]);
    }
}
