<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Floricultura Maranata | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <span class="logo">Maranata Admin</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Core</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <div class="nav-section">Atendimento</div>
            <a href="/admin/chat" class="<?php echo e(request()->is('admin/chat') ? 'active' : ''); ?>">
                <i class="fas fa-comments"></i> ChatBot 
            </a>

            <div class="nav-section">Gestão de Vendas</div>
            <a href="<?php echo e(route('admin.sales.create')); ?>" class="<?php echo e(request()->routeIs('admin.sales.*') ? 'active' : ''); ?>">
                <i class="fas fa-cash-register"></i> Realizar Venda
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                <i class="fas fa-receipt"></i> Pedidos
            </a>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="<?php echo e(request()->routeIs('admin.customers.*') ? 'active' : ''); ?>">
                <i class="fas fa-users"></i> Clientes
            </a>

            <div class="nav-section">Catálogo e Site</div>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="<?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                <i class="fas fa-seedling"></i> Produtos
            </a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                <i class="fas fa-tags"></i> Categorias
            </a>
            <a href="<?php echo e(route('admin.stock.index')); ?>" class="<?php echo e(request()->routeIs('admin.stock.*') ? 'active' : ''); ?>">
                <i class="fas fa-boxes-stacked"></i> Estoque
            </a>
            <a href="<?php echo e(route('admin.banners.index')); ?>" class="<?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>">
                <i class="fas fa-images"></i> Banners
            </a>
            
            <div class="sidebar-footer">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="logout-btn-sidebar">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="admin-main-content">
        <header class="admin-topbar">
            <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-external-link-alt"></i> Ver Loja
            </a>
            <div class="user-info">
                <i class="fas fa-user-circle me-1"></i> Administrador
            </div>
        </header>

        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
</div>


<script>
setInterval(()=>{
    fetch('/admin/chat/messages/1')
    .then(r=>r.json())
    .then(data=>{
        let unread = data.filter(m => m.sender === 'user').length;

        let badge = document.getElementById('chat-badge');

        if(unread > 0){
            badge.style.display = 'inline';
            badge.innerText = unread;

            badge.style.animation = "pulse 1s infinite";

            new Audio("https://www.soundjay.com/buttons/sounds/button-3.mp3").play();
        }
    });
},5000);
</script>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
let lastCount = 0;

setInterval(()=>{
    fetch('/admin/chat/unread')
    .then(r=>r.json())
    .then(data=>{
        let badge = document.getElementById('chat-badge');

        if(data.total > 0){
            badge.style.display = 'inline';
            badge.innerText = data.total;

            badge.style.animation = "pulse 1s infinite";

            if(data.total > lastCount){
                new Audio("https://www.soundjay.com/buttons/sounds/button-3.mp3").play();
            }

        } else {
            badge.style.display = 'none';
        }

        lastCount = data.total;
    });
},3000);
</script>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/layout.blade.php ENDPATH**/ ?>