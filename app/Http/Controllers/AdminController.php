<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Rifa;
use App\Models\Sorteio;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminController extends Controller
{

    public function loginView(Request $request)
    {
        return $this->authValidate($request) ?  redirect('/admin') : view('login');
    }

    public function adminView(Request $request)
    {
        if (!$this->authValidate($request)) {
            return redirect()->route('loginView');
        }

        $rifas = Rifa::query()->with(['santo'])->get();
        $mensagens = Mensagem::all()->toArray();

        $ultimoSorteio = Sorteio::query()
        ->with('rifa')
        ->orderByDesc('id')
        ->first();

        $ultimoSorteio = $ultimoSorteio instanceof Sorteio ? 
        $ultimoSorteio->rifa->load('santo')->toArray() : [];

        $logPath = storage_path().'/logs/laravel.log';
        $logs = fopen($logPath , "r") or die("Unable to open file!");
        $logs = explode("\n",stream_get_contents($logs));

        return view('admin', [
            'rifas' => $rifas,
            'mensagens' => $mensagens,
            'ultimoSorteio' => $ultimoSorteio,
            'logs' => $logs
        ]);
    }

    public function loginPerform(Request $request)
    {
        $senhaValida = config('auth.senha_admin');

        if ($senhaValida == $request->get('senha')) {
            $request->session()->put('autorizado', true);
            return redirect('/admin');
        }

        return redirect()->route('loginView')->with(['mensagem' => 'Senha Inválida']);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('loginView');
    }

    private function authValidate(Request $request)
    {
        if (!$request->session()->get('autorizado')) {
            return false;
        }

        return true;
    }
}
