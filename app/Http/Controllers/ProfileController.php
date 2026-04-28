<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $orders = Order::where('user_id', auth()->user()->id)
                    ->latest()
                    ->get();

        return view('pages.profile', compact('customer', 'orders'));

    }

    public function update(Request $request)
    {
        $customer = auth()->user()->customer;

        $customer->update([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'cnpj' => $request->cnpj,
            'cep' => $request->cep,
            'address' => $request->address,
            'number' => $request->number,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Perfil atualizado!');
    }
}