@extends('layouts.app')

@section('title', 'Rastrear Pedido')

@section('content')

<div class="container rast-page">

    <h1>Rastrear Pedido</h1>

    <form method="GET" action="#" class="rast-form">
        <label>Código do Pedido</label>
        <input type="text" placeholder="Ex: #12345">

        <button class="btn">Rastrear</button>
    </form>

</div>

@endsection
