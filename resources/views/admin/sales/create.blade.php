@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Realizar Venda</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- FILTRO DE PRODUTOS -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <label class="form-label fw-bold"> Buscar produto</label>
            <input type="text"
                   id="searchProduct"
                   class="form-control"
                   placeholder="Digite o nome do produto...">
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sales.store') }}">
        @csrf
    
        <!-- CLIENTE (MANTIDO CORRETO) -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Cliente
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Selecionar Cliente</label>
                        <select name="customer_id" class="form-select">
                            <option value="">Consumidor Final</option>
                            
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMA DE PAGAMENTO -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                Forma de Pagamento
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select name="payment_method" class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Pix">Pix</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- VALORES -->
        <div class="row mt-3">
            <div class="col-md-4">
                <label>Valor Recebido</label>
                <input type="number"
                    step="0.01"
                    name="amount_received"
                    id="amount_received"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label>Troco</label>
                <input type="text"
                    id="change_amount"
                    class="form-control"
                    readonly>
            </div>

            <div class="col-md-4">
                <label>Total da Venda</label>
                <input type="text"
                    id="total_sale"
                    class="form-control"
                    readonly>
            </div>
        </div>

        <!-- TABELA DE PRODUTOS -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-dark text-white">
                Produtos disponíveis
            </div>

            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0" id="productsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th width="180">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="product-row">
                            <td class="product-name fw-semibold">
                                {{ $product->name }}
                            </td>

                            <td>
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </td>

                            <td>
                                {{ $product->stock }}
                                @if($product->stock <= 5)
                                    <span class="badge bg-danger ms-2">Baixo</span>
                                @endif
                            </td>

                            <td>
                                <input type="number"
                                       name="products[{{ $product->id }}]"
                                       min="0"
                                       max="{{ $product->stock }}"
                                       class="form-control form-control-sm"
                                       placeholder="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success btn-lg">
                    ✔ Finalizar Venda
                </button>
            </div>
        </div>
    </form>

</div>

<!-- SCRIPT -->
<script>
    document.getElementById('searchProduct').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {
            let name = row.querySelector('.product-name').innerText.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });

    function formatarReal(valor) {
        return valor.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    document.addEventListener("input", function () {

        let total = 0;

        document.querySelectorAll('input[name^="products"]').forEach(input => {
            let row = input.closest('tr');

            let priceText = row.children[1].innerText
                .replace('R$', '')
                .replace('.', '')
                .replace(',', '.')
                .trim();

            let price = parseFloat(priceText) || 0;
            let quantity = parseFloat(input.value) || 0;

            total += price * quantity;
        });

        document.getElementById('total_sale').value = formatarReal(total);

        let received = parseFloat(document.getElementById('amount_received').value) || 0;
        let change = received - total;

        if (received === 0) {
            document.getElementById('change_amount').value = "R$ 0,00";
        } else if (change < 0) {
            document.getElementById('change_amount').value = "Valor insuficiente";
        } else {
            document.getElementById('change_amount').value = formatarReal(change);
        }
    });
</script>

@endsection