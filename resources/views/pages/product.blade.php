@extends('layouts.public')

@section('title', $product->name)

@section('content')

<style>
    .product-page{
    padding:40px;
    background:#f6f6f6;
    }

    .product-container{
    display:flex;
    gap:40px;
    max-width:1200px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    }

    .product-left{
    flex:1;
    }

    .product-main-img{
    width:100%;
    border-radius:8px;
    }

    .product-thumbs{
    display:flex;
    gap:10px;
    margin-top:10px;
    }

    .product-thumbs img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:6px;
    cursor:pointer;
    }

    .product-right{
    flex:1;
    }

    .product-title{
    font-size:26px;
    margin-bottom:10px;
    }

    .product-category{
    color:#777;
    margin-bottom:10px;
    }

    .product-price{
    font-size:30px;
    color:#A86E63;
    font-weight:bold;
    margin:15px 0;
    }

    .product-description{
    margin-bottom:20px;
    }

    .product-qty input{
    width:80px;
    padding:6px;
    margin-top:5px;
    }

    .product-actions{
    display:flex;
    gap:15px;
    margin-top:20px;
    }

    .btn-cart{
    background:#fff;
    border:2px solid #A86E63;
    color:#A86E63;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    }

    .btn-buy{
    background:#A86E63;
    color:white;
    padding:10px 20px;
    border-radius:6px;
    text-decoration:none;
    }

    .product-stock{
    margin-top:15px;
    color:#666;
    }
</style>

<div class="product-page">

<div class="product-container">

<div class="product-left">

@if($product->image)
<img class="product-main-img"
src="{{ asset('storage/'.$product->image) }}">
@endif

<div class="product-thumbs">

@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}">
@endif

</div>

</div>



<div class="product-right">

<h1 class="product-title">
{{ $product->name }}
</h1>

@if($product->category)
<p class="product-category">
Categoria: {{ $product->category->name }}
</p>
@endif


<div class="product-price">
R$ {{ number_format($product->price,2,',','.') }}
</div>


@if($product->description)
<p class="product-description">
{{ $product->description }}
</p>
@endif


<div class="product-qty">

<label>Quantidade</label>

<input type="number"
name="quantity"
value="1"
min="1"
max="{{ $product->stock }}">

</div>


<div class="product-actions">

<form action="{{ route('cart.add',$product->id) }}" method="POST">

@csrf

<button class="btn-cart">
Adicionar ao Carrinho
</button>

</form>


<a href="{{ route('cart.index') }}" class="btn-buy">
Comprar Agora
</a>

</div>


<p class="product-stock">
Estoque disponível: {{ $product->stock }}
</p>

</div>

</div>

</div>

<section class="related-products">

<h3>Produtos relacionados</h3>

<div class="grid">

@foreach($relatedProducts as $item)

<div class="card">

@if($item->image)
<img src="{{ asset('storage/'.$item->image) }}">
@endif

<h3>{{ $item->name }}</h3>

<p class="price">
R$ {{ number_format($item->price,2,',','.') }}
</p>

<a href="{{ route('products.show',$item->slug) }}" class="btn btn-sm">
Ver Produto
</a>

</div>

@endforeach

</div>

</section>

@endsection