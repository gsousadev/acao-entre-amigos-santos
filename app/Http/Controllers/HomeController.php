<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Bilhete;
use App\Models\Santo;
use App\Models\Sorteio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class HomeController extends Controller
{

    const LIMITE_QTD_FRALDAS_NR = 6;
    const LIMITE_QTD_FRALDAS_P = 30;
    const LIMITE_QTD_FRALDAS_M = 55;
    const LIMITE_QTD_FRALDAS_G = 17;

    public function show()
    {
        try {
            $bilhetes = Bilhete::all();

            $dadosParaTela = [
                'bilheteDosSantos' => $this->buscarSantos($bilhetes),
                'ultimoSorteio' => $this->buscarUltimoSorteio(),
            ];

            return view('home', $dadosParaTela);
        } catch (Throwable $e) {
            Log::error(
                "ERRO_BUSCAR_DADOS_HOME",
                [
                    'exception_message' => $e->getMessage(),
                    'exception_code' => $e->getCode(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                ]
            );

            $dadosParaTela = [
                'bilheteDosSantos' => [],
                'fraldas' => [],
                'mensagens' => []
            ];

            return view('home', $dadosParaTela);
        }
    }

    private function buscarUltimoSorteio(): array
    {
        $ultimoSorteio = Sorteio::query()
        ->with('bilhete')
        ->orderByDesc('id')
        ->first();

        $ultimoSorteio = $ultimoSorteio instanceof Sorteio ?
        $ultimoSorteio->bilhete->load('santo')->toArray() : [];

        return $ultimoSorteio;
    }

    private function buscarSantos(Collection $bilhetes): array
    {

        $bilhetes = Bilhete::all()->toArray();
        $santos = Santo::all()->toArray();

        foreach ($santos as &$santo) {
            $santo['escolhido'] = false;
            foreach ($bilhetes as $bilhete) {
                if ($santo['id'] == $bilhete['santo_id']) {
                    $santo['escolhido'] = true;
                    break;
                }
            }
        }

        return $santos;
    }
}
