

<?php $__env->startSection('title', 'Contato'); ?>

<?php $__env->startSection('content'); ?>

<section class="contact-page">
    <h1>Entre em Contato</h1>

    <form class="contact-form">
        <label>Nome</label>
        <input type="text">

        <label>Email</label>
        <input type="email">

        <label>Telefone</label>
        <input type="text">

        <label>Mensagem</label>
        <textarea></textarea>

        <button class="btn">Enviar</button>
    </form>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/pages/contact.blade.php ENDPATH**/ ?>