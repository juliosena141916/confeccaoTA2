<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $fillable = ['nome', 'email', 'documento', 'telefone', 'endereco', 'cidade', 'estado', 'cep'];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
