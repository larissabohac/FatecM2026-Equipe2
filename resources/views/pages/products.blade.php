@extends('layouts.public')

@section('title','Produtos')

@section('content')

<div class="container py-4">

<h2 class="mb-4 text-center">Nossos Produtos</h2>

<form method="GET" class="row mb-4 g-2">

<div class="col-md-4">

<input type="text"
name="search"
value="{{ request('search') }}"
class="form-control"
placeholder="Buscar produtos...">

</div>

<div class="col-md-3">

<select name="category" class="form-select">

<option value="">Todas categorias</option>

@foreach($categories as $cat)

<option value="{{ $cat->slug }}"
{{ request('category')==$cat->slug ? 'selected':'' }}>

{{ $cat->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<select name="sort" class="form-select">

<option value="">Ordenar</option>

<option value="price_asc"
{{ request('sort')=='price_asc'?'selected':'' }}>
Menor preço
</option>

<option value="price_desc"
{{ request('sort')=='price_desc'?'selected':'' }}>
Maior preço
</option>

</select>

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">
Filtrar
</button>

</div>

</form>


<div class="row">

@forelse($products as $product)

<div class="col-md-4 col-lg-3 mb-4">

<div class="card h-100 product-card">

@if($product->featured)

<div class="badge-featured">
Destaque
</div>

@endif


@if($product->image)

<img src="{{ asset('storage/'.$product->image) }}"
class="card-img-top product-img">

@endif

<div class="card-body text-center">

<h5>{{ $product->name }}</h5>

@if($product->category)

<p class="text-muted small">

{{ $product->category->name }}

</p>

@endif

<p class="product-price">

R$ {{ number_format($product->price,2,',','.') }}

</p>

<a href="{{ route('products.show',$product->slug) }}"
class="btn btn-success w-100">

Ver Produto

</a>

</div>

</div>

</div>

@empty

<p class="text-center">Nenhum produto encontrado.</p>

@endforelse

</div>


<div class="d-flex justify-content-center mt-4">

{{ $products->links() }}

</div>

</div>

@endsection