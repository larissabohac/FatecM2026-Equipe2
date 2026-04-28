@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 30px;">

    <h2 style="color:#8f5a5a; margin-bottom:20px;">
        Pedido #{{ $order->id }}
    </h2>

    <!-- STATUS -->
    <div style="margin-bottom:20px;">
        <strong>Status:</strong>

        @php
            $status = strtolower($order->status ?? 'em andamento');
        @endphp

        <span style="
            padding:6px 12px;
            border-radius:20px;
            color:white;
            font-size:14px;
            background:
            {{ $status == 'cancelado' ? '#dc3545' :
               ($status == 'confirmado' ? '#ffc107' :
               ($status == 'entregue' ? '#0d6efd' :
               '#198754')) }};
        ">
            {{ ucfirst($status) }}
        </span>
    </div>

    <!-- CARD -->
    <div style="
        background:#fffafa;
        padding:20px;
        border-radius:12px;
        box-shadow:0px 6px 15px rgba(0,0,0,0.05);
    ">

        <table style="width:100%; border-collapse:collapse;">

            <thead style="background:#f6eaea;">
                <tr>
                    <th style="padding:10px; text-align:left;">Produto</th>
                    <th style="padding:10px;">Qtd</th>
                    <th style="padding:10px;">Preço Unitário</th>
                    <th style="padding:10px;">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                    <tr style="border-bottom:1px solid #eee;">

                        <!-- NOME PRODUTO -->
                        <td style="padding:10px;">
                            {{ $item->product->name }}
                        </td>

                        <!-- QUANTIDADE -->
                        <td style="padding:10px; text-align:center;">
                            {{ $item->quantity }}
                        </td>

                        <!-- PREÇO UNITÁRIO -->
                        <td style="padding:10px; text-align:center;">
                            R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                        </td>

                        <!-- SUBTOTAL -->
                        <td style="padding:10px; text-align:center;">
                            R$ {{ number_format($item->total_price, 2, ',', '.') }}
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

        <!-- TOTAL -->
        <div style="margin-top:20px; text-align:right; font-size:18px;">
            <strong>Total:</strong>
            R$ {{ number_format($order->total, 2, ',', '.') }}
        </div>

    </div>

</div>

@endsection