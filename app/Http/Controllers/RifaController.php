<?php

namespace App\Http\Controllers;

use App\Mail\RifaCadastrada;
use App\Models\Rifa;
use App\Models\Santo;
use App\Models\Sorteio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class RifaController extends Controller
{
    public function create(Request $request)
    {

        try {

            $rifa = new Rifa();

            $rifa->tipo_presente = (string)trim($request->get('tipo_presente'));
            $rifa->valor_dinheiro = (float)trim(str_replace(',', '.', $request->get('valor_dinheiro')));
            $rifa->tamanho_fralda = (string)trim($request->get('tamanho_fralda'));
            $rifa->nome_convidado = (string)$request->get('nome_convidado');
            $rifa->email_convidado = (string)trim($request->get('email_convidado'));
            $rifa->telefone_convidado = $this->limparTelefone(trim($request->get('telefone_convidado')));

            $santoEscolhido = Santo::query()->where('slug', $request->get('santo_escolhido'))->first();

            $santoEscolhido->rifa()->save($rifa);

            $this->enviarEmailConfirmacao($rifa->id);

            return view('retorno_rifa', ['sucesso' => true]);
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

            return view('retorno_rifa', ['sucesso' => false]);
        }
    }
    private function limparTelefone(string $telefone): string
    {
        return (string) preg_replace("/[^0-9]/", "", $telefone);
    }

    private function enviarEmailConfirmacao(int $rifaId)
    {

        $rifa = Rifa::query()->where('id', $rifaId)->with('santo')->first();

        if ($rifa instanceof Rifa) {
            Mail::to($rifa->email_convidado)->send(new RifaCadastrada($rifa));
        } else {
            throw new ModelNotFoundException('Rifa não Localizada para envio de email');
        }
    }

    public function reenviarEmail(Request $request)
    {
        try {
            $id = $request->get('rifa');
            $this->enviarEmailConfirmacao($id);

            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Email de Rifa $id reenviado", 'tipo' => "success"]]);
        } catch (Throwable $e) {
            Log::error(
                "ERRO_REENVIO_RIFA",
                [
                    'exception_message' => $e->getMessage(),
                    'exception_code' => $e->getCode(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                    'exception_trace' => $e->getTraceAsString()
                ]
            );

            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Erro no reenvio do email da Rifa $id", 'tipo' => "danger"]]);
        }
    }

    public function markValidateTrue(Request $request)
    {
        $id = $request->get('rifa');
        $model = Rifa::find($id);
        $model->validada = true;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Rifa $id validada", 'tipo' => "success"]]);
    }

    public function markValidateFalse(Request $request)
    {
        $id = $request->get('rifa');
        $model = Rifa::find($id);
        $model->validada = false;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Rifa $id invalidada", 'tipo' => "warning"]]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('rifa');
        Rifa::find($id)->delete();
        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Rifa $id deletada", 'tipo' => "danger"]]);
    }

    public function raffle()
    {
        $rifasValidadas = Rifa::query()->where('validada', true)->with('santo')->get();

        $rifaSorteada = $rifasValidadas->shuffle()->first();

        $rifaSorteada->sorteios()->save(new Sorteio());

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Sorteio Realizado!", 'tipo' => "success"]]);
    }
}
