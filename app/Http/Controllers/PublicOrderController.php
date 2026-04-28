<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicOrderController extends Controller
{
    // Tela de checkout
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        return view('checkout', compact('cart'));
    }

    //Finalizar pedido
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'delivery_date'  => 'nullable|date',
            'observation'    => 'nullable|string'
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        DB::beginTransaction();

        try {

            $subtotal = 0;

            // Criar pedido
            $order = Order::create([
                'user_id'        => Auth::id(),
                'subtotal'       => 0,
                'shipping'       => 0,
                'total'          => 0,
                'status'         => 'confirmado',
                'payment_method' => $request->payment_method,
                'delivery_date'  => $request->delivery_date,
                'observation'    => $request->observation
            ]);

            foreach ($cart as $id => $details) {

                $product = Product::findOrFail($id);

                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Estoque insuficiente para {$product->name}");
                }

                $totalItem = $product->price * $details['quantity'];
                $subtotal += $totalItem;

                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $product->id,
                    'quantity'    => $details['quantity'],
                    'unit_price'  => $product->price,
                    'total_price' => $totalItem
                ]);

                // Atualizar estoque
                $product->stock -= $details['quantity'];
                $product->save();
            }

            $order->update([
                'subtotal' => $subtotal,
                'total'    => $subtotal
            ]);

            DB::commit();

            // Limpar carrinho
            session()->forget('cart');

            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    // Página de sucesso
    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}