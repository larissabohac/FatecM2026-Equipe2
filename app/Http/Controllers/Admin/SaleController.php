<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $customers = Customer::all();
        return view('admin.sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        // Adicionada validação para o customer_id
        $request->validate([
            'customer_id'    => 'nullable|exists:customers,id',
            'payment_method' => 'required|string',
            'products'       => 'required|array',
            'amount_received'=> 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            // Cria a venda inicial garantindo que o ID do cliente seja passado
            $sale = Sale::create([
                'customer_id'     => $request->input('customer_id'), 
                'total'           => 0,
                'payment_method'  => $request->payment_method,
                'amount_received' => $request->amount_received ?? 0,
                'change_amount'   => 0
            ]);

            foreach ($request->products as $productId => $quantity) {
                if ($quantity > 0) {
                    $product = Product::findOrFail($productId);

                    if ($product->stock < $quantity) {
                        throw new \Exception("Estoque insuficiente para: {$product->name}");
                    }

                    $product->stock -= $quantity;
                    $product->save();

                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;

                    SaleItem::create([
                        'sale_id'    => $sale->id,
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'price'      => $product->price
                    ]);
                }
            }

            if ($total <= 0) {
                throw new \Exception('A venda não pode ser finalizada sem produtos.');
            }

            // Lógica de Troco
            $change = 0;
            if ($sale->payment_method === 'Dinheiro') {
                if ($request->amount_received < $total) {
                    throw new \Exception('Valor recebido insuficiente.');
                }
                $change = $request->amount_received - $total;
            }

            $sale->update([
                'total'         => $total,
                'change_amount' => $change
            ]);

            DB::commit();

            return redirect()
                ->route('admin.sales.show', $sale->id)
                ->with('success', 'Venda realizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $sale = Sale::with(['items.product', 'customer'])->findOrFail($id);
        return view('admin.sales.show', compact('sale'));
    }

    public function index()
    {
        $sales = Sale::with('customer')->orderBy('created_at', 'desc')->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function report(Request $request)
    {
        $query = Sale::query();
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        $sales = $query->orderBy('created_at', 'desc')->get();
        $totalSales  = $sales->count();
        $totalAmount = $sales->sum('total');

        $paymentSummary = Sale::select('payment_method', DB::raw('COUNT(*) as total_sales'), DB::raw('SUM(total) as total_amount'))
            ->groupBy('payment_method')->get();

        return view('admin.sales.report', compact('sales', 'totalSales', 'totalAmount', 'paymentSummary'));
    }

    public function receipt($id)
    {
        $sale = Sale::with(['items.product', 'customer'])->findOrFail($id);
        return view('admin.sales.receipt', compact('sale'));
    }

    public function delivery($id)
    {
        $sale = Sale::with(['items.product', 'customer'])->findOrFail($id);
        return view('admin.sales.delivery', compact('sale'));
    }
}