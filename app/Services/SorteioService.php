<?php

namespace App\Services;

use App\Models\Bilhete;
use Illuminate\Database\Eloquent\Collection;

class SorteioService
{
    public function buscarBilhetesDisponiveisSorteio(): array|Collection
    {
       return Bilhete::query()
        ->where('validada', true)
        ->with(['santo'])
        ->doesntHave('sorteios')
        ->get();
    }
}
