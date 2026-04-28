@extends('layouts.app')

@section('content')

<!-- espaçamento igual padrão da home -->
<div style="padding-top: 30px;"></div>

<div class="container">

    <h2 class="fw-bold mb-4" style="color:#8f5a5a;">
        Meus Pedidos
    </h2>

    @if($orders->count() > 0)

        <div style="
            background:#fffafa;
            border-radius:16px;
            padding:25px;
            box-shadow:0px 6px 18px rgba(0,0,0,0.05);
        ">

            <table style="width:100%; border-collapse: collapse;">

                <thead style="background:#f6eaea;">
                    <tr style="color:#8f5a5a; text-align:left;">
                        <th style="padding:12px;">#</th>
                        <th style="padding:12px;">Total</th>
                        <th style="padding:12px;">Status</th>
                        <th style="padding:12px;">Ação</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        @php
                            $status = strtolower($order->status ?? 'em andamento');
                        @endphp

                        <tr style="border-bottom:1px solid #eee;">

                            <td style="padding:12px; font-weight:600;">
                                #{{ $order->id }}
                            </td>

                            <td style="padding:12px;">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>

                            <td style="padding:12px;">
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
                            </td>

                            <td style="padding:12px;">
                                <a href="{{ route('client.orders.show', $order->id) }}"
                                   style="
                                        background:#f6eaea;
                                        color:#8f5a5a;
                                        padding:6px 12px;
                                        border-radius:20px;
                                        text-decoration:none;
                                        font-size:14px;
                                   ">
                                    Ver Detalhes
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    @else

        <div style="
            background:#fffafa;
            border-radius:16px;
            padding:40px;
            text-align:center;
            box-shadow:0px 6px 18px rgba(0,0,0,0.05);
        ">

            <p style="color:#777; margin-bottom:15px;">
                Você ainda não fez pedidos.
            </p>

            <a href="{{ route('products.index') }}"
               style="
                    background:#b57b7b;
                    color:white;
                    padding:10px 20px;
                    border-radius:20px;
                    text-decoration:none;
               ">
                Ver Produtos
            </a>

        </div>

    @endif

</div>
@endsection