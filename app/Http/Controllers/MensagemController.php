<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MensagemController extends Controller
{
    public function create(Request $request)
    {
        try {
            $mensagem = new Mensagem();

            $mensagem->nome = $request->get('nome');
            $mensagem->mensagem = $request->get('mensagem');

            $mensagem->save();

            return view('retorno_mensagem', ['sucesso' => true]);
        } catch (Throwable $e) {
            Log::error(
                "ERRO_CADASTRO_MENSAGEM",
                [
                    'exception_message' => $e->getMessage(),
                    'exception_code' => $e->getCode(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                    'exception_trace' => $e->getTraceAsString()
                ]
            );

            return view('retorno_mensagem', ['sucesso' => false]);
        }
    }

    public function markValidateTrue(Request $request)
    {
        $id = $request->get('mensagem');
        $model = Mensagem::find($id);
        $model->validada = true;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem'=> "Mensagem $id validada", 'tipo' => "success"]]);
    }

    public function markValidateFalse(Request $request)
    {
        $id = $request->get('mensagem');
        $model = Mensagem::find($id);
        $model->validada = false;
        $model->save();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem'=> "Mensagem $id invalidada", 'tipo' => "warning"]]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('mensagem');
        Mensagem::find($id)->delete();

        return redirect('/admin')->with(['mensagem_alerta' => ['mensagem'=> "Mensagem $id deletada", 'tipo' => "danger"]]);
    }
}
