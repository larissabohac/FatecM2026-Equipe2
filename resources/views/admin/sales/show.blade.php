@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="card shadow mx-auto print-area" style="max-width: 700px">

        <div class="card-header text-center bg-dark text-white no-print">
            <h4 class="mb-0"> Comprovante de Venda</h4>
        </div>

        <div class="card-body">

            <div class="text-center mb-3">
                <h5>Floricultura Maranata</h5>
                <small>CNPJ: 47.440.048/0001-84</small>
            </div>

            <p>
                <strong>Nº:</strong> {{ $sale->id }} <br>
                <strong>Data:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}<br>
                <strong>Pagamento:</strong> {{ $sale->payment_method }}
            </p>

            <table class="table table-sm">
                <thead class="no-print">
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Valor</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                            <td>
                                R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h5 class="text-end">
                Total: <strong>R$ {{ number_format($sale->total, 2, ',', '.') }}</strong>
            </h5>

            <div class="text-center mt-3 small">
                Obrigada pela preferência!
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between no-print">
            <a href="{{ route('admin.sales.create') }}" class="btn btn-secondary">
                Nova Venda
            </a>
                @php
                    $message = "Pedido Nº {$sale->id}\n";
                    $message .= "Total: R$ " . number_format($sale->total, 2, ',', '.') . "\n";
                    $message .= "Obrigado pela preferência!";
                @endphp

                <a target="_blank"
                    href="https://wa.me/5518996773917{{ $sale->customer->phone ?? 'SEUNUMERO' }}?text={{ urlencode($message) }}"
                    class="btn btn-success">
                        Enviar WhatsApp
                </a>
            <a href="{{ route('admin.sales.receipt', $sale->id) }}" 
                target="_blank" 
                class="btn btn-primary">
                Imprimir Cupom Cliente
            </a>

            <a href="{{ route('admin.sales.delivery', $sale->id) }}" 
                target="_blank" 
                class="btn btn-warning">
                Imprimir Cupom Entregador
            </a>
        </div>

    </div>

</div>

<!-- ESTILO DE IMPRESSÃO -->
<style>
@media print {

    body {
        margin: 0;
        padding: 0;
    }

    .no-print {
        display: none !important;
    }

    .print-area {
        width: 280px !important;
        max-width: 280px !important;
        margin: 0 auto;
        box-shadow: none !important;
        border: none !important;
    }

    table {
        font-size: 12px;
    }

    h5 {
        font-size: 14px;
    }

    body, * {
        font-family: monospace;
    }
}
</style>


@if(session('success'))
<script>
    window.onload = function() {
        let saleId = {{ $sale->id }};

        window.open('/admin/sales/' + saleId + '/receipt', '_blank');
        window.open('/admin/sales/' + saleId + '/delivery', '_blank');
    }
</script>
@endif

@endsection