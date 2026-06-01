<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produtos extends Model
{
    protected $fillable = ['nome', 'descricao', 'preco', 'categoria', 'sku'];

    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class);
    }

    public function itensPedidos(): HasMany
    {
        return $this->hasMany(ItemPedido::class, 'produtos_id');
    }
}

