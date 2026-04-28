

<?php $__env->startSection('title','Admin - Produtos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center">
        <h1>Produtos</h1>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn">Novo Produto</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table" style="width:100%;margin-top:16px;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;">
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                <td style="width:120px">
                    <?php if($p->image): ?>
                        <img src="<?php echo e(asset('storage/'.$p->image)); ?>" 
                             style="width:90px;height:60px;object-fit:cover;border-radius:6px"/>
                    <?php else: ?>
                        <div style="width:90px;height:60px;background:#efe6e5;border-radius:6px"></div>
                    <?php endif; ?>
                </td>

                <td><?php echo e($p->name); ?></td>

                <td>
                    <?php echo e($p->category->name ?? 'Sem categoria'); ?>

                </td>

                <td>
                    R$ <?php echo e(number_format($p->price, 2, ',', '.')); ?>

                </td>

                <td><?php echo e($p->stock); ?></td>

                <td>
                    <a href="<?php echo e(route('admin.products.edit', $p)); ?>" class="btn btn-sm">
                        Editar
                    </a>

                    <form action="<?php echo e(route('admin.products.destroy', $p)); ?>" 
                          method="POST" 
                          style="display:inline-block"
                          onsubmit="return confirm('Remover este produto?')">

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button class="btn btn-sm" type="submit">
                            Remover
                        </button>

                    </form>
                </td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div style="margin-top:18px">
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/products/index.blade.php ENDPATH**/ ?>