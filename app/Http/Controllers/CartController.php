<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Buscar ou criar carrinho
     */
    private function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'status' => 'active'
                ]
            );
        } else {
            $sessionId = session()->getId();

            $cart = Cart::firstOrCreate(
                [
                    'session_id' => $sessionId,
                    'status' => 'active'
                ]
            );
        }

        return $cart;
    }

    /**
     * Adicionar produto ao carrinho
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price_snapshot' => $product->price
            ]);
        }

        return redirect()->route('cart.index')
                         ->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Atualizar quantidade de um item no carrinho
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($id);
        
        $item->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart.index')
                         ->with('success', 'Quantidade atualizada!');
    }

    /**
     * Mostrar carrinho
     */
    public function index()
    {
        $cart = $this->getCart();

        $items = $cart
            ? $cart->items()->with('product')->get()
            : collect();

        $addons = Product::where('is_addon', true)->get();

        return view('cart.index', compact('items', 'addons'));
    }

    /**
     * Remover item do carrinho
     */
    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return redirect()->route('cart.index')
                        ->with('success', 'Produto removido do carrinho!');
    }

    /**
     * Finalizar compra
     */
    public function checkout(Request $request)
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')
                             ->with('success', 'Seu carrinho está vazio.');
        }

        $subtotal = 0;

        foreach ($cart->items as $item) {
            $subtotal += $item->quantity * $item->price_snapshot;
        }

        // Criar pedido
        $order = Order::create([
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'shipping' => 0,
            'total' => $subtotal,
            'status' => 'confirmado',
            'payment_method' => 'pix'
        ]);

        // Criar itens do pedido
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price_snapshot,
                'total_price' => $item->quantity * $item->price_snapshot
            ]);
        }

        // Finalizar carrinho
        $cart->status = 'active';
        $cart->save();

        $cart->items()->delete();

        return redirect()->route('order.success', $order);
    }

    /**
     * Página de sucesso
     */
    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}