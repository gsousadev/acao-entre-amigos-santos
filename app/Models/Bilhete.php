<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

/**
 * @property string $id
 * @property string $nome_convidado
 * @property string $email_convidado
 * @property string $telefone_convidado
 */
class Bilhete extends Model
{
    const UPDATED_AT = null;
    use HasFactory;


    public function santo(): BelongsTo
    {
        return $this->belongsTo(Santo::class);
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->timezone(config('app.timezone'))->format('d/m/y H:i:s'),
        );
    }

    public function sorteios(): HasMany
    {
        return $this->hasMany(Sorteio::class);
    }
}
