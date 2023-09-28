<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Santo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class BilheteController extends Controller
{
    public function create(Request $request)
    {
        try {
            $bilhete = new Bilhete();

            $bilhete->nome_convidado = (string)$request->get('nome_convidado');
            $bilhete->telefone_convidado = $this->limparTelefone(trim($request->get('telefone_convidado')));

            $santoEscolhido = Santo::query()
            ->where('slug', $request->get('santo_escolhido'))
            ->doesntHave('bilhete')
            ->first();

            if(!$santoEscolhido instanceof Santo){
                throw new \Exception('Bilhete já comprado para o santo escolhido');
            }

            $santoEscolhido->bilhete()->save($bilhete);

            return view('retorno_bilhete', ['sucesso' => true, 'bilhete' => $bilhete, 'santo' => $santoEscolhido]);
        } catch (Throwable $e) {

            Log::error(
                "ERRO_CADASTRO_RIFA",
                [
                    'exception_message' => $e->getMessage(),
                    'exception_code' => $e->getCode(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                    'exception_trace' => $e->getTraceAsString()
                ]
            );

            return view('retorno_bilhete', ['sucesso' => false]);
        }
    }
    private function limparTelefone(string $telefone): string
    {
        return (string) preg_replace("/[^0-9]/", "", $telefone);
    }


    public function markValidateTrue(Request $request)
    {
        $id = $request->get('bilhete');
        $model = Bilhete::find($id);
        $model->validada = true;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Bilhete $id validada", 'tipo' => "success"]]);
    }

    public function markValidateFalse(Request $request)
    {
        $id = $request->get('bilhete');
        $model = Bilhete::find($id);
        $model->validada = false;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Bilhete $id invalidada", 'tipo' => "warning"]]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('bilhete');
        Bilhete::find($id)->delete();
        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Bilhete $id deletada", 'tipo' => "danger"]]);
    }
}
