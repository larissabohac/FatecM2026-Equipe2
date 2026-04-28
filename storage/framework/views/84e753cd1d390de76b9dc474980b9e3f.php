

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-secondary">Banners do Carrossel</h2>
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-rosa-escuro">
            <i class="fas fa-plus me-2"></i>Novo Banner
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-vinho text-white">
                    <tr>
                        <th class="ps-4">Miniatura</th>
                        <th>Título / Link</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="ps-4 align-middle">
                            <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="img-thumbnail" style="width: 100px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="align-middle fw-semibold">
                            <?php echo e($banner->title); ?><br>
                            <small class="text-muted"><?php echo e($banner->link ?? 'Sem link'); ?></small>
                        </td>
                        <td class="align-middle">
                            <span class="badge <?php echo e($banner->active ? 'bg-success' : 'bg-secondary'); ?>">
                                <?php echo e($banner->active ? 'Ativo' : 'Inativo'); ?>

                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <a href="<?php echo e(route('admin.banners.edit', $banner)); ?>" class="btn btn-sm btn-outline-warning border-0">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="<?php echo e(route('admin.banners.destroy', $banner)); ?>" method="POST" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Excluir este banner?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>