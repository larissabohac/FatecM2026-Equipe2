

<?php $__env->startSection('title', 'Início - Floricultura Maranata'); ?>

<?php $__env->startSection('content'); ?>

<div id="bannerCarousel"
     class="carousel slide carousel-fade mb-4"
     data-bs-ride="carousel"
     data-bs-interval="4000">

<!-- indicadores -->
<div class="carousel-indicators">

<?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<button type="button"
data-bs-target="#bannerCarousel"
data-bs-slide-to="<?php echo e($key); ?>"
class="<?php echo e($key == 0 ? 'active' : ''); ?>">
</button>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>


<div class="carousel-inner">

<?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">

<img src="<?php echo e(asset('storage/'.$banner->image)); ?>"
     class="d-block w-100 banner-img"
     alt="<?php echo e($banner->title); ?>">

<div class="carousel-caption banner-caption">

<h2><?php echo e($banner->title); ?></h2>

<?php if($banner->link): ?>

<a href="<?php echo e($banner->link); ?>" class="btn btn-light">
Ver mais
</a>

<?php endif; ?>

</div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

    <?php $__currentLoopData = $menuCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <a class="cat" href="<?php echo e(route('category.products', $category->slug)); ?>">
            <?php echo e($category->name); ?>

        </a>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</section>


<section class="products">
    <h2>Produtos em Destaque</h2>
    <div class="grid">
    <?php $__empty_1 = true; $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="card">
            <div class="card-badge">Destaque</div>
            <?php if($product->image): ?>
                <img src="<?php echo e(asset('storage/'.$product->image)); ?>">
            <?php else: ?>
                <img src="<?php echo e(asset('images/prod1.jpg')); ?>">
            <?php endif; ?>
            <h3><?php echo e($product->name); ?></h3>
            <p class="price">
                R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?>

            </p>
            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-sm">
                Comprar
            </a>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>Nenhum produto em destaque no momento.</p>
    <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/pages/home.blade.php ENDPATH**/ ?>