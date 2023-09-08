<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sorteio extends Model
{
    const UPDATED_AT = null;
    protected $table = 'sorteios';

    use HasFactory;

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>
            Carbon::parse($value)
            ->timezone(config('app.timezone'))
            ->format('d/m/y H:i:s'),
        );
    }

    public function rifa(): BelongsTo
    {
        return $this->belongsTo(Rifa::class);
    }
}
