<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable  = [
        'code',
        'name',
        'is_active'
    ];
    public function rates() {
        return $this->hasMany(ExchangeRate::class);
    }
}
