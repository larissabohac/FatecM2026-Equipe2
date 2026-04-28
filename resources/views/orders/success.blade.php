@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">

    <div class="card shadow border-0 rounded-4 p-5 text-center"
         style="max-width: 600px; background: #fffafa;">

        <h2 class="mb-3" style="color:#8f5a5a;">
             Pedido realizado com sucesso!
        </h2>

        <p class="fs-5">
            Obrigada por comprar na <strong>Floricultura Maranata</strong>.
        </p>

        <p class="text-muted mb-4">
            Seu pedido já foi registrado e será preparado com muito carinho
        </p>

        <div class="card bg-light border-0 rounded-4 p-3 mb-4 text-start">
            <p class="mb-1">
                <strong>Número do pedido:</strong> #{{ $order->id }}
            </p>

            <p class="mb-1">
                <strong>Total:</strong>
                R$ {{ number_format($order->total, 2, ',', '.') }}
            </p>

            <p class="mb-0">
                <strong>Status:</strong>
                <span class="badge bg-warning text-dark">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('client.orders') }}"
               class="btn rounded-pill px-4"
               style="background:#b57b7b; color:white;">
                Meus pedidos
            </a>

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-secondary rounded-pill px-4">
                Continuar comprando
            </a>
        </div>

    </div>

</div>
@endsection