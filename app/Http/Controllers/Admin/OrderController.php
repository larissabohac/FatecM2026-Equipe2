<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // LISTAR PEDIDOS (ADMIN)
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // DETALHES DO PEDIDO (ADMIN)
    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    // FINALIZAR COMPRA ONLINE (CLIENTE)
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'payment_method' => 'required|string'
        ]);

        DB::beginTransaction();

        try {

            $subtotal = 0;

            //CRIA PEDIDO
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

            //CRIA ITENS + ATUALIZA ESTOQUE
            foreach ($request->cart as $productId => $quantity) {

                $product = Product::findOrFail($productId);

                if ($product->stock < $quantity) {
                    throw new \Exception(
                        "Estoque insuficiente para {$product->name}"
                    );
                }

                $totalItem = $product->price * $quantity;
                $subtotal += $totalItem;

                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $product->id,
                    'quantity'    => $quantity,
                    'unit_price'  => $product->price,
                    'total_price' => $totalItem
                ]);

                //Atualiza estoque
                $product->stock -= $quantity;
                $product->save();
            }

            //ATUALIZA TOTAIS
            $order->update([
                'subtotal' => $subtotal,
                'total'    => $subtotal
            ]);

            DB::commit();

            return redirect()
                ->route('orders.success', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        // Não permitir alterar pedido cancelado ou entregue
        if (in_array($order->status, ['cancelado', 'entregue'])) {
            return back()->with('error', 'Este pedido não pode mais ser alterado.');
        }

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status atualizado com sucesso!');
    }
    public function cancel(Order $order)
    {
        if ($order->status === 'entregue') {
            return back()->with('error', 'Pedido já entregue não pode ser cancelado.');
        }

        if ($order->status === 'cancelado') {
            return back()->with('error', 'Pedido já está cancelado.');
        }

        DB::beginTransaction();

        try {

            //Devolver estoque
            foreach ($order->items as $item) {

                $product = Product::find($item->product_id);

                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $order->update([
                'status' => 'cancelado'
            ]);

            DB::commit();

            return back()->with('success', 'Pedido cancelado e estoque devolvido.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Erro ao cancelar pedido.');
        }
    }
}