@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">🛒 Finalizar Compra</h2>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Resumo do Pedido</div>
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Qtd</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp

                        @foreach($cart as $id => $details)
                            @php
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                            @endphp

                            <tr>
                                <td>{{ $details['name'] }}</td>
                                <td>{{ $details['quantity'] }}</td>
                                <td>R$ {{ number_format($subtotal,2,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="text-end">
                    Total: R$ {{ number_format($total,2,',','.') }}
                </h5>
            </div>
        </div>

        <!-- Pagamento -->
        <div class="card mb-4">
            <div class="card-header">💳 Forma de Pagamento</div>
            <div class="card-body">
                <select name="payment_method" class="form-select" required>
                    <option value="">Selecione</option>
                    <option value="Pix">Pix</option>
                    <option value="Cartão">Cartão de Crédito</option>
                </select>
            </div>
        </div>

        <!-- Data de entrega -->
        <div class="card mb-4">
            <div class="card-header">📅 Entrega</div>
            <div class="card-body">
                <input type="date"
                       name="delivery_date"
                       class="form-control"
                       min="{{ now()->toDateString() }}">
            </div>
        </div>

        <!-- Observação -->
        <div class="card mb-4">
            <div class="card-header">📝 Observações</div>
            <div class="card-body">
                <textarea name="observation"
                          class="form-control"
                          rows="3"
                          placeholder="Mensagem para presente, horário especial, etc."></textarea>
            </div>
        </div>

        <button class="btn btn-success btn-lg w-100">
            Confirmar Pedido
        </button>

    </form>

</div>
@endsection