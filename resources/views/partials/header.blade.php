<header class="site-header">

    <!-- Barra superior -->
    <div class="topbar">
        <div class="container">
            <span>☎ (11) 99999-9999 • Entrega rápida em toda região</span>
        </div>
    </div>

    <!-- Navbar principal -->
    <div class="nav container">
        
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            Floricultura Maranata
        </a>

        <!-- Menu -->
        <nav class="menu">
            <a href="{{ url('/') }}">Início</a>
            <a href="{{ url('/produtos') }}">Produtos</a>
            <a href="{{ url('/contato') }}">Contato</a>
        </nav>

        <!-- Ícones -->
        <div class="icons">
            <button id="searchToggle" aria-label="Buscar">🔍</button>
            <a href="#" class="user">👤</a>
            <a href="#" class="cart">🛒</a>
        </div>

    </div>

</header>
