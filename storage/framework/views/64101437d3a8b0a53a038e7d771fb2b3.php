<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Floricultura Maranata')); ?></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body class="font-sans text-gray-900 antialiased" style="background:#F3E9E7;">

    <div class="min-h-screen flex flex-col justify-center items-center">

        <div style="text-align:center; margin-bottom:20px;">
            <h1 style="color:#b57b7b; font-size:32px; font-weight:bold;">
                 Floricultura Maranata
            </h1>
        </div>

        <div class="w-full sm:max-w-md">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>

</body>
</html><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/layouts/guest.blade.php ENDPATH**/ ?>