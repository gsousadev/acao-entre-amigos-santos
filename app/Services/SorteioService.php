<?php

namespace App\Services;

use App\Models\Bilhete;
use App\Models\Sorteio;
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

    public function buscarSorteiosRealizados(): Collection|array
    {
        return Sorteio::query()
            ->with('bilhete.santo')
            ->orderByDesc('id')
            ->get();
    }

    public function buscarBilhetesComprados(): Collection| array
    {
        return Bilhete::query()->with(['santo'])->get();
    }
}
