@extends('layouts.app')

@section('content')

<div style="padding:40px; text-align:center;">
    <h1 style="font-size:28px; color:#b57b7b;">
        Bem-vindo à Floricultura Maranata
    </h1>

    <p style="margin-top:10px; color:#555;">
        Você está logado com sucesso!
    </p>

    <div style="margin-top:30px;">
        <a href="{{ route('products.index') }}" style="
            background:#b57b7b;
            color:white;
            padding:12px 20px;
            border-radius:8px;
            text-decoration:none;
        ">
            Ver Produtos
        </a>
    </div>
</div>

@endsection