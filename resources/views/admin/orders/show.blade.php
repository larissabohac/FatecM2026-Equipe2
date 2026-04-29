@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Pedido #{{ $order->id }}</h2>

    <!-- DADOS DO CLIENTE -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            Cliente
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $order->user->name ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
        </div>
    </div>

    <!-- INFORMAÇÕES DO PEDIDO -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            Informações do Pedido
        </div>
        <div class="card-body">
            <p><strong>Forma de Pagamento:</strong> {{ $order->payment_method }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-primary">
                    @switch($order->status)
                        @case('realizado') Pedido realizado @break
                        @case('confirmado') Pagamento confirmado @break
                        @case('preparando') Pedido preparando @break
                        @case('enviado') Pedido enviado @break
                        @case('entregue') Pedido entregue @break
                        @case('cancelado') Pedido cancelado @break
                    @endswitch
                </span>
            </p>

            <p>
                <strong>Data desejada de entrega:</strong>
                {{ $order->delivery_date
                    ? \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y')
                    : 'Não informada' }}
            </p>
            <p>
                <strong>Observação do Cliente:</strong><br>

                @if($order->observation)
                    <div class="p-3 bg-light rounded">
                        {{ $order->observation }}
                    </div>
                @else
                    <span class="text-muted">Nenhuma observação informada.</span>
                @endif
            </p>
        </div>
        
    </div>

    <!-- ITENS -->
    <div class="card shadow-sm">
        <div class="card-header">
            Produtos Comprados
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Valor Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produto removido' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                            </td>
                            <td>
                                R$ {{ number_format($item->total_price, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="card-footer text-end">
            <h5>
                Total do Pedido:
                <strong>
                    R$ {{ number_format($order->total, 2, ',', '.') }}
                </strong>
            </h5>
        </div>
    </div>

</div>

@if(!in_array($order->status, ['cancelado', 'entregue']))

<form method="POST"
      action="{{ route('admin.orders.updateStatus', $order->id) }}"
      class="mb-3">
    @csrf
    @method('PUT')

    <label>Alterar Status:</label>

    <select name="status" class="form-select mb-2">
        <option value="realizado">Pedido realizado</option>
        <option value="confirmado">Pagamento confirmado</option>
        <option value="preparando">Pedido preparando</option>
        <option value="enviado">Pedido enviado</option>
        <option value="entregue">Pedido entregue</option>
    </select>

    <button class="btn btn-primary btn-sm">
        Atualizar Status
    </button>
</form>

@endif
@if($order->status !== 'cancelado' && $order->status !== 'entregue')

<form method="POST"
      action="{{ route('admin.orders.cancel', $order->id) }}"
      onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
    @csrf
    @method('PUT')

    <button class="btn btn-danger btn-sm">
        Cancelar Pedido
    </button>
</form>

@endif


<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
    Voltar
</a>
@endsection

