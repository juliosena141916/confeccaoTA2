<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $guarded = [];

    public function Produtos() {
        return $this->belongsTo(Produtos::class);
    }
}
