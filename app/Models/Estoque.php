<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estoque extends Model
{
    protected $fillable = ['produtos_Id', 'quantidade', 'localizacao', 'quantidade_minima', 'valor'];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'quantidade_minima' => 'integer',
        'valor' => 'decimal:2',
    ];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produtos::class, 'produtos_Id');
    }
}
