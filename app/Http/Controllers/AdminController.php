<?php

namespace App\Http\Controllers;

use App\Services\SorteioService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(private SorteioService $sorteioService){
    }

    public function loginView(Request $request)
    {
        return $this->authValidate($request) ?  redirect('/admin') : view('login');
    }

    public function adminView(Request $request)
    {
        if (!$this->authValidate($request)) {
            return redirect()->route('loginView');
        }

        $bilhetesComprados = $this->sorteioService->buscarBilhetesComprados();

        $sorteiosRealizados = $this->sorteioService->buscarSorteiosRealizados();

        $logPath = storage_path().'/logs/laravel.log';
        $logs = fopen($logPath , "r") or die("Unable to open file!");
        $logs = explode("\n",stream_get_contents($logs));

        return view('admin', [
            'bilhetes' => $bilhetesComprados,
            'sorteios' => $sorteiosRealizados,
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
