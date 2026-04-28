<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Buscar carrinho ativo
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        // Verifica se existe carrinho ou itens
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Carrinho vazio!');
        }

        // CALCULAR TOTAL (SEM ERRO)
        $total = 0;

        foreach ($cart->items as $item) {
            $total += $item->quantity * $item->product->price;
        }

        // Criar pedido
       $order = Order::create([
        'user_id' => Auth::id(),
        'subtotal' => $total, 
        'total' => $total,
        'status' => 'confirmado'
]);

        // (Opcional) aqui depois você pode salvar itens do pedido

        // Limpar carrinho
        $cart->items()->delete();
        $cart->update(['status' => 'closed']);
        $cart->items()->delete();
        
        // Redirecionar com mensagem
        return redirect()->route('dashboard')
            ->with('success', 'Pedido realizado com sucesso!');
    }
}