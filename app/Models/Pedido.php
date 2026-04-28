<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos'; // Forçando o nome da tabela em português

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'metodo_pagamento',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com os itens (flores) do pedido
    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }
}