<?php

namespace App\Http\Controllers;

use App\Mail\BilheteCadastrada;
use App\Models\Bilhete;
use App\Models\Santo;
use App\Models\Sorteio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class BilheteController extends Controller
{
    public function create(Request $request)
    {

        try {

            $bilhete = new Bilhete();

            $bilhete->nome_convidado = (string)$request->get('nome_convidado');
            $bilhete->email_convidado = (string)trim($request->get('email_convidado'));
            $bilhete->telefone_convidado = $this->limparTelefone(trim($request->get('telefone_convidado')));

            $santoEscolhido = Santo::query()->where('slug', $request->get('santo_escolhido'))->first();

            $santoEscolhido->bilhete()->save($bilhete);

            $this->enviarEmailConfirmacao($bilhete->id);

            return view('retorno_bilhete', ['sucesso' => true]);
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

    private function enviarEmailConfirmacao(int $bilheteId)
    {

        $bilhete = Bilhete::query()->where('id', $bilheteId)->with('santo')->first();

        if ($bilhete instanceof Bilhete) {
            Mail::to($bilhete->email_convidado)->send(new BilheteCadastrada($bilhete));
        } else {
            throw new ModelNotFoundException('Bilhete não Localizada para envio de email');
        }
    }

    public function reenviarEmail(Request $request)
    {
        try {
            $id = $request->get('bilhete');
            $this->enviarEmailConfirmacao($id);

            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Email de Bilhete $id reenviado", 'tipo' => "success"]]);
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

            return redirect('/admin')->with(['mensagem_alerta' => ['mensagem' => "Erro no reenvio do email da Bilhete $id", 'tipo' => "danger"]]);
        }
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
