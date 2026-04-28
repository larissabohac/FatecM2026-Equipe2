<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 5mm; }
        body { font-family: monospace; width: 260px; margin: 0 auto; font-size: 14px; }
        .center { text-align: center; }
        .big { font-size: 18px; font-weight: bold; }
        hr { border-top: 2px dashed #000; margin: 10px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <strong>ENTREGA</strong><br>
        <strong>Floricultura Maranata</strong>
    </div>
    <hr>
    <p><strong>Pedido Nº:</strong> {{ $sale->id }}</p>
    <hr>
    <p class="big">
        {{ $sale->customer->name ?? 'Cliente não informado' }}
    </p>
    <hr>
    @if($sale->customer)
        <p class="big">
            {{ $sale->customer->address ?? '' }}, {{ $sale->customer->number ?? '' }}
        </p>
        <p class="big">
            {{ $sale->customer->neighborhood ?? '' }}
        </p>
        <p class="big">
            {{ $sale->customer->city ?? '' }} / {{ $sale->customer->state ?? '' }}
        </p>
    @else
        <p class="big">Endereço não informado</p>
    @endif
    <hr>
    <p class="big">
        TEL: {{ $sale->customer->phone ?? '-' }}
    </p>
    <hr>
    <p><strong>Itens:</strong></p>
    @foreach($sale->items as $item)
        <p>{{ $item->quantity }}x {{ $item->product->name }}</p>
    @endforeach
    <hr>
    <p class="center">Entregar com carinho e cuidado!</p>
</body>
</html>