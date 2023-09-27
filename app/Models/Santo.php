<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Santo extends Model
{
    use HasFactory;


    public function bilhete(): HasOne
    {
        return $this->hasOne(Bilhete::class);
    }
}
