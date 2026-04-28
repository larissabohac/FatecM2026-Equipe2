@extends('layouts.guest')

@section('content')
<style>
    :root {
        --vinho: #4A2C2A;
        --rosa-escuro: #A86E63;
        --fundo: #FBF9F8;
    }
    body { background-color: var(--fundo); }
    
    .main-cart-wrapper { max-width: 1200px; margin: 0 auto; width: 100%; }

    .cart-table-card { border-radius: 1.5rem; border: none; overflow: hidden; background: white; }
    
    .table thead th { 
        background: #FDF8F7; 
        color: var(--rosa-escuro); 
        padding: 15px 20px; 
        font-size: 0.75rem; 
        text-transform: uppercase;
        letter-spacing: 1px; 
        border: none;
    }

    /* Ajuste da imagem para não quebrar o layout */
    .product-img-cart {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
    }

    .qty-selector {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #EAE0DE;
        border-radius: 50px;
        width: fit-content;
        margin: 0 auto;
        overflow: hidden;
    }
    .qty-selector button { 
        border: none; 
        background: transparent; 
        padding: 5px 15px; 
        color: var(--vinho);
        transition: 0.2s;
    }
    .qty-selector button:hover { background: #FDF8F7; }
    .qty-selector input { width: 40px; border: none; text-align: center; font-weight: bold; background: transparent; pointer-events: none; }

    .summary-card { 
        border-radius: 1.5rem; 
        border: none; 
        background: #fff; 
        padding: 30px;
        position: sticky;
        top: 20px;
    }
</style>

<div class="container-fluid py-5">
    <div class="main-cart-wrapper">
        
        <div class="mb-4 px-3">
            <h2 class="fw-bold" style="color: var(--vinho)">Meu Carrinho</h2>
            <span class="badge rounded-pill px-3 py-2" style="background: var(--fundo); color: var(--rosa-escuro)">
                {{ $items->count() }} {{ $items->count() > 1 ? 'itens' : 'item' }}
            </span>
        </div>

        @if($items->count() > 0)
            <div class="row g-4">
                {{-- LISTA DE PRODUTOS --}}
                <div class="col-lg-8">
                    <div class="card cart-table-card shadow-sm">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Produto</th>
                                        <th class="text-center">Preço</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalGeral = 0; @endphp
                                    @foreach($items as $item)
                                        @php 
                                            $subtotal = $item->quantity * $item->price_snapshot;
                                            $totalGeral += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center py-2">
                                                    <img src="{{ asset('storage/products/' . $item->product->image) }}" 
                                                         class="product-img-cart border"
                                                         onerror="this.src='https://placehold.co/80x80/FDF8F7/A86E63?text=🌸'">
                                                    <div class="ms-3">
                                                        <p class="mb-0 fw-bold" style="color: var(--vinho)">{{ $item->product->name }}</p>
                                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="btn p-0 text-muted" style="font-size: 0.75rem; text-decoration: underline;">Remover Item</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">R$ {{ number_format($item->price_snapshot, 2, ',', '.') }}</td>
                                            <td>
                                                <div class="qty-selector shadow-sm">
                                                    {{-- Botão Menos --}}
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                        <button type="submit" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                                    </form>
                                                    
                                                    <input type="text" value="{{ $item->quantity }}">
                                                    
                                                    {{-- Botão Mais --}}
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                        <button type="submit">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 fw-bold" style="color: var(--vinho)">
                                                R$ {{ number_format($subtotal, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="text-decoration-none fw-bold" style="color: var(--rosa-escuro)">
                            <i class="bi bi-arrow-left me-2"></i>Continuar comprando
                        </a>
                    </div>
                </div>

                {{-- CARD DE RESUMO --}}
                <div class="col-lg-4">
                    <div class="summary-card shadow-sm">
                        <h5 class="fw-bold mb-4" style="color: var(--vinho)">Resumo da compra</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal ({{ $items->count() }} {{ $items->count() > 1 ? 'itens' : 'item' }})</span>
                            <span>R$ {{ number_format($totalGeral, 2, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Entrega</span>
                            <span class="badge bg-light text-success border border-success-subtle">Grátis para Prudente</span>
                        </div>

                        <hr class="my-4" style="border-top: 1px dashed #D8A7A0;">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h5 fw-bold mb-0">Total</span>
                            <span class="h4 fw-bold mb-0" style="color: var(--rosa-escuro)">R$ {{ number_format($totalGeral, 2, ',', '.') }}</span>
                        </div>

                        @auth
                            {{-- AJUSTADO: Rota em minúsculo conforme o padrão que definimos no web.php --}}
                            <a href="{{ route('pagamento.index') }}" class="btn w-100 py-3 text-white fw-bold shadow text-decoration-none text-center" style="background: var(--vinho); border-radius: 12px;">
                                FINALIZAR PEDIDO
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn w-100 py-3 text-white fw-bold text-center text-decoration-none shadow" style="background: var(--rosa-escuro); border-radius: 12px;">
                                ENTRAR PARA COMPRAR
                            </a>
                        @endauth
                        
                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="bi bi-shield-check me-1"></i> Pagamento 100% Seguro</small>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-5 shadow-sm">
                <div class="mb-3">🌸</div>
                <h4 class="text-muted">Sua cesta está vazia</h4>
                <p class="mb-4">Que tal escolher um arranjo lindo agora?</p>
                <a href="{{ route('products.index') }}" class="btn px-5 text-white" style="background: var(--rosa-escuro); border-radius: 50px;">Ver Produtos</a>
            </div>
        @endif
    </div>
</div>
@endsection