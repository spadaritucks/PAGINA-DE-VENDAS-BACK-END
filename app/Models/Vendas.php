<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'vendedor_id',
        'forma_pagamento',
        'valor_integral',
        'parcelas',
        'created_at'
    ];
}
