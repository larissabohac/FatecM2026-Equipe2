@extends('admin.layout')

@section('content')
<h2>🧾 Pedido #{{ $order->id }}</h2>

<p><strong>Cliente:</strong> {{ $order->user->name }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>

<hr>

<h4>Itens do Pedido</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Qtd</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
            <td>{{ $item->quantity }}</td>
            <td>R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
    Voltar
</a>
@endsection