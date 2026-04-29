@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">👤 {{ $user->name }}</h2>

    <div class="card mb-4 p-4">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Total de pedidos:</strong> {{ $user->orders->count() }}</p>
        <p><strong>Total gasto:</strong>
            R$ {{ number_format($totalSpent, 2, ',', '.') }}
        </p>
    </div>

    <h4>📦 Pedidos do Cliente</h4>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Total</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection