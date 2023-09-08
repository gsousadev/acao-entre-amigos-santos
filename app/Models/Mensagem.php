<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    const UPDATED_AT = null;
    protected $table = 'mensagens';

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
}
