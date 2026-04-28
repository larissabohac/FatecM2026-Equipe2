<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.stock.index', compact('products'));
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);
        $product->stock += $request->quantity;
        $product->save();

        return back()->with('success', 'Entrada de estoque registrada com sucesso.');
    }

    public function remove(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Estoque insuficiente.');
        }

        $product->stock -= $request->quantity;
        $product->save();

        return back()->with('success', 'Saída de estoque registrada com sucesso.');
    }
}