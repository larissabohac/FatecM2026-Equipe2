

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <h2 class="mb-4">Pedidos Online</h2>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>

                            <td>
                                <?php echo e($order->user->name ?? 'Usuário removido'); ?>

                            </td>

                            <td>
                                R$ <?php echo e(number_format($order->total, 2, ',', '.')); ?>

                            </td>

                            <td>
                                <?php echo e($order->payment_method ?? '-'); ?>

                            </td>

                            <td>
                                <?php
                                    $labels = [
                                        'realizado' => 'secondary',
                                        'confirmado' => 'success',
                                        'preparando' => 'warning',
                                        'enviado' => 'primary',
                                        'entregue' => 'dark',
                                        'cancelado' => 'danger'
                                    ];
                                ?>

                                <span class="badge bg-<?php echo e($labels[$order->status] ?? 'secondary'); ?>">
                                    <?php switch($order->status):
                                        case ('realizado'): ?> Pedido realizado <?php break; ?>
                                        <?php case ('confirmado'): ?> Pagamento confirmado <?php break; ?>
                                        <?php case ('preparando'): ?> Pedido preparando <?php break; ?>
                                        <?php case ('enviado'): ?> Pedido enviado <?php break; ?>
                                        <?php case ('entregue'): ?> Pedido entregue <?php break; ?>
                                        <?php case ('cancelado'): ?> Pedido cancelado <?php break; ?>
                                    <?php endswitch; ?>
                                </span>
                            </td>

                            <td>
                                <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                            </td>

                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Nenhum pedido encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>