<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Listar clientes
     */
    public function index()
    {
        $customers = User::where('role', 'user')
            ->withCount('orders')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Detalhes do cliente
     */
    public function show(User $user)
    {
        $user->load('orders');

        $totalSpent = $user->orders->sum('total');

        return view('admin.customers.show', compact('user', 'totalSpent'));
    }
}

