<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
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

    public function authValidate(Request $request)
    {
        if (!$request->session()->get('autorizado')) {
            return false;
        }

        return true;
    }

    public function loginView(Request $request)
    {
        return $this->authValidate($request) ?  redirect('/admin') : view('login');
    }
}
