<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="font-bold text-gray-800">
                    Floricultura Maranata
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700">Home</a>
                <a href="{{ route('products.index') }}" class="text-gray-700">Produtos</a>
                <a href="{{ route('contact.show') }}" class="text-gray-700">Contato</a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700">Dashboard</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600">Sair</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-gray-700">Entrar</a>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden px-4 pb-4">
        <a href="{{ route('home') }}" class="block py-2">Home</a>
        <a href="{{ route('products.index') }}" class="block py-2">Produtos</a>
        <a href="{{ route('contact.show') }}" class="block py-2">Contato</a>

        @auth
            <a href="{{ route('admin.dashboard') }}" class="block py-2">Dashboard</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block py-2 text-red-600">Sair</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="block py-2">Entrar</a>
        @endguest
    </div>
</nav>
