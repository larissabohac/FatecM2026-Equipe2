@extends('admin.layout')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Pedidos Online</h2>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>

                            <td>
                                {{ $order->user->name ?? 'Usuário removido' }}
                            </td>

                            <td>
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>

                            <td>
                                {{ $order->payment_method ?? '-' }}
                            </td>

                            <td>
                                @php
                                    $labels = [
                                        'realizado' => 'secondary',
                                        'confirmado' => 'success',
                                        'preparando' => 'warning',
                                        'enviado' => 'primary',
                                        'entregue' => 'dark',
                                        'cancelado' => 'danger'
                                    ];
                                @endphp

                                <span class="badge bg-{{ $labels[$order->status] ?? 'secondary' }}">
                                    @switch($order->status)
                                        @case('realizado') Pedido realizado @break
                                        @case('confirmado') Pagamento confirmado @break
                                        @case('preparando') Pedido preparando @break
                                        @case('enviado') Pedido enviado @break
                                        @case('entregue') Pedido entregue @break
                                        @case('cancelado') Pedido cancelado @break
                                    @endswitch
                                </span>
                            </td>

                            <td>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Nenhum pedido encontrado.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection