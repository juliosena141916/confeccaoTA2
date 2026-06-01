<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = ['nome', 'descricao', 'preco_unitario', 'preco_custo', 'quantidade_disponivel', 'unidade_medida', 'estoque'];

    protected $casts = [
        'preco_custo' => 'decimal:2',
        'estoque' => 'decimal:2',
    ];
}
