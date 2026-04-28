@extends('admin.layout')

@section('content')
<h2> Pedidos</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                    Ver
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection