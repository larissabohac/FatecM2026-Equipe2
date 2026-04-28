<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Product;
use App\Models\Cart; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    // Tela de Checkout (Resumo antes de pagar)
    public function index()
    {
        // Busca os itens do carrinho do usuário logado
        $itens = Cart::where('user_id', Auth::id())->get();
        
        if ($itens->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        // Soma o total baseada no snapshot de preço que você já tem no carrinho
        $total = $itens->sum(fn($i) => $i->quantity * $i->price_snapshot);

        // AJUSTADO: Apontando para a pasta 'Pagamento' com P maiúsculo conforme seu print
        return view('Pagamento.index', compact('itens', 'total'));
    }

    // Processa a baixa no estoque e cria o pedido
    public function processar(Request $request)
    {
        $itensCarrinho = Cart::where('user_id', Auth::id())->get();

        if ($itensCarrinho->isEmpty()) {
            return redirect()->route('home');
        }

        try {
            // TRANSACTION: Se der erro em qualquer produto, o Laravel desfaz tudo automaticamente
            DB::transaction(function () use ($itensCarrinho, $request) {
                
                // 1. Criar o Pedido Principal na tabela 'pedidos'
                $pedido = Pedido::create([
                    'user_id' => Auth::id(),
                    'total' => $itensCarrinho->sum(fn($i) => $i->quantity * $i->price_snapshot),
                    'status' => 'pago', 
                    'metodo_pagamento' => $request->metodo_pagamento ?? 'pix'
                ]);

                foreach ($itensCarrinho as $item) {
                    // 2. Trava o registro para ninguém comprar a mesma flor no mesmo milissegundo
                    $produto = Product::lockForUpdate()->find($item->product_id);

                    // 3. Verificar se ainda tem estoque real
                    if ($produto->stock < $item->quantity) {
                        throw new \Exception("Poxa, o estoque de '{$produto->name}' acabou enquanto você finalizava!");
                    }

                    // 4. BAIXAR O ESTOQUE NO BANCO (Admin e Cliente verão o valor reduzido)
                    $produto->decrement('stock', $item->quantity);

                    // 5. Salvar o item no histórico do pedido
                    ItemPedido::create([
                        'pedido_id' => $pedido->id,
                        'product_id' => $item->product_id,
                        'quantidade' => $item->quantity,
                        'preco_unitario' => $item->price_snapshot,
                    ]);
                }

                // 6. Limpar o carrinho do cliente após o sucesso
                Cart::where('user_id', Auth::id())->delete();
            });

            return redirect()->route('pagamento.sucesso')->with('success', 'Pedido realizado com sucesso!');

        } catch (\Exception $e) {
            // Se faltar estoque ou der erro no banco, volta para o carrinho com a mensagem de erro
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function sucesso()
    {
        // AJUSTADO: Apontando para a sua pasta 'Pagamento'
        return view('Pagamento.success'); 
    }
}