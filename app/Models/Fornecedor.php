<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $fillable = ['nome', 'email', 'telefone', 'endereco', 'cidade', 'estado', 'cep', 'cnpj'];
}
