@extends('layouts.public')

@section('content')
<style>
    :root {
        --vinho: #4A2C2A;
        --rosa-escuro: #A86E63;
        --borda: #F2E8E6;
        --sucesso: #2E7D32;
    }
    body { background-color: #FBF9F8; }
    .checkout-wrapper { width: 100%; padding: 0 4%; }
    .card-pagamento {
        background: white;
        border: 1px solid var(--borda);
        border-radius: 20px;
        padding: 30px;
    }
    .metodo-item {
        border: 2px solid var(--borda);
        border-radius: 15px;
        padding: 20px;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .metodo-item:hover { border-color: var(--rosa-escuro); background: #FDF8F7; }
    input[type="radio"]:checked + .metodo-item {
        border-color: var(--vinho);
        background: #FDF8F7;
    }
    .btn-confirmar {
        background: var(--vinho);
        color: white;
        border-radius: 12px;
        padding: 20px;
        font-weight: bold;
        width: 100%;
        border: none;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }
    .item-resumo img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-5">
    <div class="checkout-wrapper">
        <h2 class="fw-bold mb-5 text-center">Finalizar seu Pedido</h2>

        <form action="{{ route('pagamento.processar') }}" method="POST">
            @csrf
            <div class="row g-5">
                
                {{-- COLUNA ESQUERDA: PAGAMENTO E DADOS DO CLIENTE --}}
                <div class="col-lg-7">
                    <div class="card-pagamento shadow-sm">
                        <h4 class="fw-bold mb-4">Como deseja pagar?</h4>
                        
                        <label class="w-100">
                            <input type="radio" name="metodo_pagamento" value="pix" class="d-none" checked>
                            <div class="metodo-item">
                                <img src="https://logospng.org/download/pix/logo-pix-1024.png" height="30" class="me-3">
                                <div>
                                    <strong class="d-block">PIX (Aprovação imediata)</strong>
                                    <small class="text-muted">O código será gerado após confirmar.</small>
                                </div>
                                <i class="bi bi-check-circle-fill ms-auto text-success fs-4"></i>
                            </div>
                        </label>

                        <label class="w-100">
                            <input type="radio" name="metodo_pagamento" value="cartao" class="d-none">
                            <div class="metodo-item">
                                <i class="bi bi-credit-card-2-back fs-2 me-3 text-muted"></i>
                                <div>
                                    <strong class="d-block">Cartão de Crédito</strong>
                                    <small class="text-muted">Parcelamento em até 12x.</small>
                                </div>
                            </div>
                        </label>

                        <div class="mt-5">
                            <h4 class="fw-bold mb-3">Informações de Entrega</h4>
                            <p class="text-muted small mb-4">Confirmamos seus dados de cadastro para entrega:</p>
                            
                            <div class="row g-3">
                                {{-- DEFINIMOS A VARIÁVEL CUSTOMER PARA PUXAR OS DADOS DO BANCO --}}
                                @php $customer = auth()->user()->customer; @endphp

                                <div class="col-md-12">
                                    <label class="small text-muted">Endereço (Rua e Número)</label>
                                    <input type="text" name="endereco" class="form-control form-control-lg border-0 bg-light" 
                                           value="{{ $customer->address ?? '' }}{{ isset($customer->number) ? ', ' . $customer->number : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Cidade</label>
                                    <input type="text" name="cidade" class="form-control form-control-lg border-0 bg-light" 
                                           value="{{ $customer->city ?? '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">WhatsApp / Telefone</label>
                                    <input type="text" name="telefone" class="form-control form-control-lg border-0 bg-light" 
                                           value="{{ $customer->phone ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLUNA DIREITA: RESUMO FINAL --}}
                <div class="col-lg-5">
                    <div class="card-pagamento shadow-sm sticky-top" style="top: 20px;">
                        <h4 class="fw-bold mb-4">Resumo dos itens</h4>
                        
                        <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($itens as $item)
                                {{-- VERIFICA SE EXISTE O PRODUTO PARA EVITAR ERRO DE 'NULL' --}}
                                @if($item->product) 
                                    <div class="d-flex align-items-center mb-3 item-resumo">
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}" 
                                             onerror="this.src='https://placehold.co/60x60/FDF8F7/A86E63?text=🌸'">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                            {{-- USAMOS O PRICE_SNAPSHOT QUE VEM DO SEU CONTROLLER --}}
                                            <small class="text-muted">{{ $item->quantity }}x R$ {{ number_format($item->price_snapshot, 2, ',', '.') }}</small>
                                        </div>
                                        <span class="fw-bold text-end">R$ {{ number_format($item->quantity * $item->price_snapshot, 2, ',', '.') }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <hr style="border-top: 1px dashed var(--borda);">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Frete</span>
                            <span class="text-success fw-bold">GRÁTIS</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h4 fw-bold mb-0">Total Final</span>
                            <span class="h2 fw-bold mb-0" style="color: var(--rosa-escuro)">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn-confirmar shadow">
                            CONFIRMAR E PAGAR AGORA
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection