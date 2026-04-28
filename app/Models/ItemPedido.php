<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'itens_pedido';

    protected $fillable = [
        'pedido_id',
        'product_id',
        'quantidade',
        'preco_unitario',
    ];

    public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}