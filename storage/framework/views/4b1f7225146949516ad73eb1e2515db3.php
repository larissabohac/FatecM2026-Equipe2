

<?php $__env->startSection('title','Produtos'); ?>

<?php $__env->startSection('content'); ?>

<div class="container py-4">

<h2 class="mb-4 text-center">Nossos Produtos</h2>

<form method="GET" class="row mb-4 g-2">

<div class="col-md-4">

<input type="text"
name="search"
value="<?php echo e(request('search')); ?>"
class="form-control"
placeholder="Buscar produtos...">

</div>

<div class="col-md-3">

<select name="category" class="form-select">

<option value="">Todas categorias</option>

<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($cat->slug); ?>"
<?php echo e(request('category')==$cat->slug ? 'selected':''); ?>>

<?php echo e($cat->name); ?>


</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

</div>

<div class="col-md-3">

<select name="sort" class="form-select">

<option value="">Ordenar</option>

<option value="price_asc"
<?php echo e(request('sort')=='price_asc'?'selected':''); ?>>
Menor preço
</option>

<option value="price_desc"
<?php echo e(request('sort')=='price_desc'?'selected':''); ?>>
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

<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<div class="col-md-4 col-lg-3 mb-4">

<div class="card h-100 product-card">

<?php if($product->featured): ?>

<div class="badge-featured">
Destaque
</div>

<?php endif; ?>


<?php if($product->image): ?>

<img src="<?php echo e(asset('storage/'.$product->image)); ?>"
class="card-img-top product-img">

<?php endif; ?>

<div class="card-body text-center">

<h5><?php echo e($product->name); ?></h5>

<?php if($product->category): ?>

<p class="text-muted small">

<?php echo e($product->category->name); ?>


</p>

<?php endif; ?>

<p class="product-price">

R$ <?php echo e(number_format($product->price,2,',','.')); ?>


</p>

<a href="<?php echo e(route('products.show',$product->slug)); ?>"
class="btn btn-success w-100">

Ver Produto

</a>

</div>

</div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<p class="text-center">Nenhum produto encontrado.</p>

<?php endif; ?>

</div>


<div class="d-flex justify-content-center mt-4">

<?php echo e($products->links()); ?>


</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/pages/products.blade.php ENDPATH**/ ?>