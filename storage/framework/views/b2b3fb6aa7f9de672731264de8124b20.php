

<?php $__env->startSection('content'); ?>
<h2>Banners da Home</h2>

<a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary mb-3">
    Novo Banner
</a>

<table class="table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><img src="<?php echo e(asset('storage/'.$banner->image)); ?>" height="60"></td>
                <td><?php echo e($banner->active ? 'Ativo' : 'Inativo'); ?></td>
                <td>
                    <form method="POST" action="<?php echo e(route('admin.banners.destroy',$banner)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>