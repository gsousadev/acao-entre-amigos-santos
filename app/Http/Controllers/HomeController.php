<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Rifa;
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
            $rifas = Rifa::all();

            $dadosParaTela = [
                'rifaDosSantos' => $this->buscarSantos($rifas),
                'fraldas' => $this->buscarQuantidadeFraldasRestantes($rifas),
                'mensagens' => $this->buscarMensagens(),
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
                'rifaDosSantos' => [],
                'fraldas' => [],
                'mensagens' => []
            ];

            return view('home', $dadosParaTela);
        }
    }

    private function buscarUltimoSorteio(): array
    {
        $ultimoSorteio = Sorteio::query()
        ->with('rifa')
        ->orderByDesc('id')
        ->first();

        $ultimoSorteio = $ultimoSorteio instanceof Sorteio ? 
        $ultimoSorteio->rifa->load('santo')->toArray() : [];

        return $ultimoSorteio;
    }

    private function buscarSantos(Collection $rifas): array
    {

        $rifas = Rifa::all()->toArray();
        $santos = Santo::all()->toArray();

        foreach ($santos as &$santo) {
            $santo['escolhido'] = false;
            foreach ($rifas as $rifa) {
                if ($santo['id'] == $rifa['santo_id']) {
                    $santo['escolhido'] = true;
                    break;
                }
            }
        }

        return $santos;
    }

    private function buscarQuantidadeFraldasRestantes(Collection $rifas): array
    {

        $qtdFraldasRn = $rifas->filter(function (Rifa $rifa) {
            return $rifa->tamanho_fralda == 'rn';
        })->count();

        $qtdFraldasP = $rifas->filter(function (Rifa $rifa) {
            return $rifa->tamanho_fralda == 'p';
        })->count();

        $qtdFraldasM = $rifas->filter(function (Rifa $rifa) {
            return $rifa->tamanho_fralda == 'm';
        })->count();

        $qtdFraldasG = $rifas->filter(function (Rifa $rifa) {
            return $rifa->tamanho_fralda == 'g';
        })->count();

        return [
            'rn' => self::LIMITE_QTD_FRALDAS_NR == $qtdFraldasRn ? false : true,
            'p' => self::LIMITE_QTD_FRALDAS_P == $qtdFraldasP ? false : true,
            'm' => self::LIMITE_QTD_FRALDAS_M == $qtdFraldasM ? false : true,
            'g' => self::LIMITE_QTD_FRALDAS_G == $qtdFraldasG ? false : true,
        ];
    }

    private function buscarMensagens(): array
    {
        return  Mensagem::query()->where('validada', true)->get()->toArray();
    }
}
