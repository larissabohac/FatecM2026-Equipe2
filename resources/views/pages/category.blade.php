@extends('layouts.public')

@section('title', $category->name)

@section('content')

<section class="products">

<h2>{{ $category->name }}</h2>

<div class="grid">

@forelse($products as $product)

<article class="card">

@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}">
@endif

<h3>{{ $product->name }}</h3>

<p class="price">
R$ {{ number_format($product->price,2,',','.') }}
</p>

<a href="{{ route('products.show',$product->slug) }}" class="btn btn-sm">
Ver Produto
</a>

</article>

@empty

<p>Nenhum produto nesta categoria.</p>

@endforelse

</div>

<div style="margin-top:30px">
{{ $products->links() }}
</div>

</section>

@endsection