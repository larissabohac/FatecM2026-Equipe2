

<?php $__env->startSection('content'); ?>
<div class="container">

    <h2 class="mb-4">Clientes</h2>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Pedidos</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td><?php echo e($customer->orders_count); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>"
                           class="btn btn-sm btn-outline-primary">
                            Ver
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>