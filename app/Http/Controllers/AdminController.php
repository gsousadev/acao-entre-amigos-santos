<?php

namespace App\Http\Controllers;

use App\Services\SorteioService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(private SorteioService $sorteioService){
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
}
