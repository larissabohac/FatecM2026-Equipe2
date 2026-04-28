<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Floricultura Maranata') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- JS -->
    @vite(['resources/js/app.js'])
</head>
<body>

<!-- NAVBAR -->
<header class="main-nav">
    <div class="nav-container">

        <a href="{{ route('home') }}" class="logo">
            Floricultura Maranata
        </a>

        <nav class="menu">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('products.index') }}">Produtos</a>
    <a href="{{ route('contact.show') }}">Contato</a>

    @guest
        <a href="{{ route('login') }}">Login</a>
    @endguest

    @auth
        <a href="{{ route('dashboard') }}">Minha Conta</a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">Admin</a>
        @endif

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" style="background:none; border:none; cursor:pointer;">
        Sair
    </button>
</form>
    @endauth
</nav>
    </div>
</header>

<!-- CONTEÚDO -->
<main class="container">
    @yield('content')
</main>

</body>
</html>