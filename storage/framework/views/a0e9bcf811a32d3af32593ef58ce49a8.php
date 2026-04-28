

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold text-vinho mb-1">Bem-vindo, <?php echo e(Auth::user()->name ?? 'Admin'); ?>!</h2>
            <p class="text-muted">Aqui está o resumo da Floricultura Maranata.</p>
        </div>
        <div class="col-md-6">
            <form method="GET" class="d-flex gap-2 justify-content-md-end">
                <div class="input-group input-group-sm shadow-sm w-auto bg-white rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-calendar text-rosa-escuro"></i></span>
                    <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" class="form-control border-0">
                    <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" class="form-control border-0">
                    <button class="btn btn-rosa-escuro border-0 px-3">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <?php
            // No seu Controller, você deve calcular essas variáveis de porcentagem
            // Exemplo: $prodChange, $featChange, $userChange, $orderChange
            $cards = [
                [
                    'label' => 'Produtos', 
                    'value' => $totalProducts ?? 0, 
                    'icon' => 'fa-leaf', 
                    'color' => '#A86E63', 
                    'bg' => '#fdf6f5',
                    'change' => $prodChange ?? '+0%', 
                    'trend' => ($prodChange ?? 0) >= 0 ? 'up' : 'down'
                ],
                [
                    'label' => 'Destaques', 
                    'value' => $featured ?? 0, 
                    'icon' => 'fa-star', 
                    'color' => '#ffc107', 
                    'bg' => '#fffbeb',
                    'change' => $featChange ?? '+0%', 
                    'trend' => ($featChange ?? 0) >= 0 ? 'up' : 'down'
                ],
                [
                    'label' => 'Usuários', 
                    'value' => $totalUsers ?? 0, 
                    'icon' => 'fa-user-friends', 
                    'color' => '#0d6efd', 
                    'bg' => '#f0f7ff',
                    'change' => $userChange ?? '+0%', 
                    'trend' => ($userChange ?? 0) >= 0 ? 'up' : 'down'
                ],
                [
                    'label' => 'Vendas', 
                    'value' => $totalOrders ?? 0, 
                    'icon' => 'fa-shopping-cart', 
                    'color' => '#198754', 
                    'bg' => '#f0fff4',
                    'change' => $orderChange ?? '+0%', 
                    'trend' => ($orderChange ?? 0) >= 0 ? 'up' : 'down'
                ],
            ];
        ?>

        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 border-bottom border-4" style="border-color: <?php echo e($card['color']); ?> !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="p-3 rounded-3" style="background-color: <?php echo e($card['bg']); ?>; color: <?php echo e($card['color']); ?>;">
                            <i class="fas <?php echo e($card['icon']); ?> fa-lg"></i>
                        </div>
                        
                        
                        <span class="badge rounded-pill small <?php echo e($card['trend'] === 'up' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'); ?>">
                            <?php echo e($card['change']); ?>

                            <i class="fas fa-arrow-<?php echo e($card['trend'] === 'up' ? 'up' : 'down'); ?> ms-1"></i>
                        </span>
                    </div>
                    <h6 class="text-muted small fw-bold text-uppercase tracking-wider mb-1"><?php echo e($card['label']); ?></h6>
                    <h2 class="fw-extrabold mb-0" style="color: var(--vinho);"><?php echo e($card['value']); ?></h2>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold text-vinho mb-0">Desempenho de Vendas</h5>
                        <p class="text-muted small">Evolução do faturamento</p>
                    </div>
                    <div class="text-end">
                        <h3 class="fw-bold text-rosa-escuro mb-0">R$ <?php echo e(number_format($totalRevenue ?? 0, 2, ',', '.')); ?></h3>
                        <span class="badge bg-vinho-subtle text-vinho px-3">Receita Total</span>
                    </div>
                </div>
                <canvas id="monthlyChart" style="max-height: 320px;"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-vinho mb-2">Meios de Pagamento</h5>
                <p class="text-muted small mb-4">Distribuição por preferência</p>
                <div class="position-relative py-3">
                    <canvas id="paymentChart"></canvas>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <?php $__currentLoopData = $salesByPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-circle me-2" style="color: <?php echo e(['#A86E63', '#4A2C2A', '#D8A7A0', '#F3E9E7'][$loop->index] ?? '#ccc'); ?>; font-size: 10px;"></i>
                            <span class="text-muted small fw-medium"><?php echo e($payment->payment_method); ?></span>
                        </div>
                        <span class="fw-bold text-vinho small"><?php echo e($payment->total_sales); ?> un.</span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    :root {
        --vinho: #4A2C2A;
        --rosa-escuro: #A86E63;
        --vinho-subtle: rgba(74, 44, 42, 0.1);
    }
    .fw-extrabold { font-weight: 800; }
    .bg-success-subtle { background-color: #e8f5e9; }
    .bg-danger-subtle { background-color: #fce4ec; }
    .tracking-wider { letter-spacing: 0.08em; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-8px); }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuração do Gráfico Mensal com Gradiente
const ctx = document.getElementById('monthlyChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(168, 110, 99, 0.3)');
gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($monthlySales->map(fn($s) => "Mês ".$s->month)); ?>,
        datasets: [{
            data: <?php echo json_encode($monthlySales->pluck('total')); ?>,
            borderColor: '#A86E63',
            borderWidth: 4,
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            pointRadius: 0, // Esconde os pontos para um look mais clean
            pointHoverRadius: 6,
            pointBackgroundColor: '#A86E63'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: '#f0f0f0', drawBorder: false }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false } }
        }
    }
});

// Gráfico de Meios de Pagamento
new Chart(document.getElementById('paymentChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($salesByPayment->pluck('payment_method')); ?>,
        datasets: [{
            data: <?php echo json_encode($salesByPayment->pluck('total_amount')); ?>,
            backgroundColor: ['#A86E63', '#4A2C2A', '#D8A7A0', '#F3E9E7'],
            hoverOffset: 10,
            borderWidth: 0
        }]
    },
    options: {
        cutout: '82%',
        plugins: { legend: { display: false } }
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>