@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">📊 Relatório de Vendas</h2>

    <!-- FILTRO -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sales.report') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label>Data Inicial</label>
                        <input type="date" name="start_date"
                               value="{{ request('start_date') }}"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Data Final</label>
                        <input type="date" name="end_date"
                               value="{{ request('end_date') }}"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary">
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- RESUMO -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>Total de Vendas</h5>
                    <h3>{{ $totalSales }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-dark text-white shadow-sm">
                <div class="card-body">
                    <h5>Faturamento Total</h5>
                    <h3>R$ {{ number_format($totalAmount, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
    <div class="card-header">
        📊 Vendas por Forma de Pagamento
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Método</th>
                    <th>Qtd Vendas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentSummary as $payment)
                <tr>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->total_sales }}</td>
                    <td>R$ {{ number_format($payment->total_amount,2,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<canvas id="paymentChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('paymentChart');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            @foreach($paymentSummary as $payment)
                "{{ $payment->payment_method }}",
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($paymentSummary as $payment)
                    {{ $payment->total_amount }},
                @endforeach
            ]
        }]
    }
});
</script>

    <!-- TABELA -->
    <div class="card shadow-sm">
        <div class="card-header">
            Lista de Vendas
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Comprovante</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                R$ {{ number_format($sale->total, 2, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.sales.show', $sale->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Nenhuma venda encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-end">
            <button onclick="window.print()" class="btn btn-secondary">
                🖨 Imprimir Relatório
            </button>
        </div>
    </div>

</div>
@endsection