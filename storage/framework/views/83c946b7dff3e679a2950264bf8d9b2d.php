

<?php $__env->startSection('content'); ?>
<div class="container">

    <h2 class="mb-4">Controle de Estoque</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Entrada</th>
                <th>Saída</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($product->name); ?></td>
                    <td>R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></td>
                    <td>
                        <?php echo e($product->stock); ?>


                        <?php if($product->stock <= 5): ?>
                            <span class="badge bg-danger">Baixo</span>
                        <?php endif; ?>
                    </td>

                    <td style="width:180px">
                        <form method="POST" action="<?php echo e(route('admin.stock.add', $product->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input type="number" name="quantity" min="1" class="form-control">
                                <button class="btn btn-success btn-sm">+</button>
                            </div>
                        </form>
                    </td>

                    <td style="width:180px">
                        <form method="POST" action="<?php echo e(route('admin.stock.remove', $product->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input type="number" name="quantity" min="1" class="form-control">
                                <button class="btn btn-danger btn-sm">−</button>
                            </div>
                        </form>
                    </td>

                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/stock/index.blade.php ENDPATH**/ ?>