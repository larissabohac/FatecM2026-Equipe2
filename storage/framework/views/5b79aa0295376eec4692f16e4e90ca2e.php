

<?php $__env->startSection('title', $category->name); ?>

<?php $__env->startSection('content'); ?>

<section class="products">

<h2><?php echo e($category->name); ?></h2>

<div class="grid">

<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<article class="card">

<?php if($product->image): ?>
<img src="<?php echo e(asset('storage/'.$product->image)); ?>">
<?php endif; ?>

<h3><?php echo e($product->name); ?></h3>

<p class="price">
R$ <?php echo e(number_format($product->price,2,',','.')); ?>

</p>

<a href="<?php echo e(route('products.show',$product->slug)); ?>" class="btn btn-sm">
Ver Produto
</a>

</article>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<p>Nenhum produto nesta categoria.</p>

<?php endif; ?>

</div>

<div style="margin-top:30px">
<?php echo e($products->links()); ?>

</div>

</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/pages/category.blade.php ENDPATH**/ ?>