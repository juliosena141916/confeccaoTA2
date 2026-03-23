<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $guarded = [];

    public function Produto() {
        return $this->belongsTo(Produtos::class);
    }
}
