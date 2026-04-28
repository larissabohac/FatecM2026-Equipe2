<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: auto; margin: 5mm; }
        body { font-family: monospace; width: 260px; margin: 5px auto; font-size: 13px; }
        .center { text-align: center; }
        hr { border-top: 1px dashed #000; margin: 8px 0; }
        .item { display: flex; justify-content: space-between; }
        .small { font-size: 11px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <strong>Floricultura Maranata</strong><br>
        <span class="small">CNPJ: 47.400.640/0001-84</span>
    </div>
    <hr>
    <div class="center small">{{ $sale->created_at->format('d/m/Y H:i') }}</div>
    <div>
        Nº: {{ $sale->id }} <br>
        Pagamento: {{ $sale->payment_method }}
    </div>
    <hr>
    @if($sale->customer)
        <div>
            <span class="bold">Cliente:</span><br>
            {{ $sale->customer->name }} <br>
            Tel: {{ $sale->customer->phone ?? '-' }}
        </div>
        <hr>
        <div>
            <span class="bold">Endereço:</span><br>
            {{ $sale->customer->address ?? '' }}, {{ $sale->customer->number ?? '' }}<br>
            {{ $sale->customer->neighborhood ?? '' }} - {{ $sale->customer->city ?? '' }}
        </div>
        <hr>
    @endif
    @foreach($sale->items as $item)
        <div>
            <div>{{ $item->quantity }}x {{ $item->product->name }}</div>
            <div class="item">
                <span></span>
                <span>R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
            </div>
        </div>
    @endforeach
    <hr>
    <div class="item bold">
        <span>Total</span>
        <span>R$ {{ number_format($sale->total, 2, ',', '.') }}</span>
    </div>
    @if($sale->payment_method == 'Dinheiro')
        <div class="item">
            <span>Pago</span>
            <span>R$ {{ number_format($sale->amount_received, 2, ',', '.') }}</span>
        </div>
        <div class="item">
            <span>Troco</span>
            <span>R$ {{ number_format($sale->change_amount, 2, ',', '.') }}</span>
        </div>
    @endif
    <hr>
    <div class="center">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=Pedido {{ $sale->id }} Total {{ number_format($sale->total, 2) }}">
    </div>
    <hr>
    <p class="center small">Sistema Floricultura Maranata</p>
</body>
</html>