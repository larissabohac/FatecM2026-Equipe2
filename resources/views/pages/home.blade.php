@extends('layouts.public')

@section('title', 'Início - Floricultura Maranata')

@section('content')

<div id="bannerCarousel"
     class="carousel slide carousel-fade mb-4"
     data-bs-ride="carousel"
     data-bs-interval="4000">

<!-- indicadores -->
<div class="carousel-indicators">

@foreach($banners as $key => $banner)

<button type="button"
data-bs-target="#bannerCarousel"
data-bs-slide-to="{{ $key }}"
class="{{ $key == 0 ? 'active' : '' }}">
</button>

@endforeach

</div>


<div class="carousel-inner">

@foreach($banners as $key => $banner)

<div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

<img src="{{ asset('storage/'.$banner->image) }}"
     class="d-block w-100 banner-img"
     alt="{{ $banner->title }}">

<div class="carousel-caption banner-caption">

<h2>{{ $banner->title }}</h2>

@if($banner->link)

<a href="{{ $banner->link }}" class="btn btn-light">
Ver mais
</a>

@endif

</div>

</div>

@endforeach

</div>


<!-- botões -->
<button class="carousel-control-prev"
type="button"
data-bs-target="#bannerCarousel"
data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>

</button>

<button class="carousel-control-next"
type="button"
data-bs-target="#bannerCarousel"
data-bs-slide="next">

<span class="carousel-control-next-icon"></span>

</button>

</div>

<section class="hero">
    <div class="hero-inner">

        <div class="hero-text">
            <h1>Flores que Encantam</h1>
            <p>Buquês, arranjos e presentes especiais para todas as ocasiões.</p>
            <a class="btn" href="/produtos">Ver Produtos</a>
        </div>



    </div>
</section>

<section class="categories">
    <h2>Categorias</h2>

    <div class="cats-grid">

    @foreach($menuCategories as $category)

        <a class="cat" href="{{ route('category.products', $category->slug) }}">
            {{ $category->name }}
        </a>

    @endforeach

    </div>

</section>


<section class="products">
    <h2>Produtos em Destaque</h2>
    <div class="grid">
    @forelse($featuredProducts as $product)
        <article class="card">
            <div class="card-badge">Destaque</div>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}">
            @else
                <img src="{{ asset('images/prod1.jpg') }}">
            @endif
            <h3>{{ $product->name }}</h3>
            <p class="price">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </p>
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm">
                Comprar
            </a>
        </article>
    @empty
        <p>Nenhum produto em destaque no momento.</p>
    @endforelse
    </div>
</section>

@endsection
