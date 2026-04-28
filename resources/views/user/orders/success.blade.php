@extends('layouts.app')

@section('content')
<div class="container text-center">

    <div class="card shadow-sm p-5">

        <h2 class="text-success mb-3">✅ Pedido Realizado com Sucesso!</h2>

        <p><strong>Número do Pedido:</strong> #{{ $order->id }}</p>

        <p><strong>Status:</strong> 
            {{ ucfirst($order->status) }}
        </p>

        <p><strong>Total:</strong> 
            R$ {{ number_format($order->total,2,',','.') }}
        </p>

        @if($order->delivery_date)
            <p><strong>Entrega prevista:</strong>
                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}
            </p>
        @endif

        <a href="{{ route('home') }}"
           class="btn btn-primary mt-3">
            Voltar para Loja
        </a>

    </div>

</div>
@endsection