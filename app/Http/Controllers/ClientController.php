<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('client.orders', compact('orders'));
    }

   public function show($id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.show', compact('order'));
    }
}