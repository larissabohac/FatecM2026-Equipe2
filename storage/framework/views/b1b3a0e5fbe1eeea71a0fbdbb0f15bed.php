

<?php $__env->startSection('content'); ?>

<div style="display:flex; height:80vh;">

<!-- LISTA DE SESSÕES -->
<div style="width:30%; border-right:1px solid #ccc; overflow:auto;">
    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div onclick="openChat(<?php echo e($s->id); ?>)"
             style="padding:10px; cursor:pointer; border-bottom:1px solid #eee;">
            Chat #<?php echo e($s->id); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- CHAT -->
<div style="flex:1; display:flex; flex-direction:column;">
    
    <div id="chat-box" style="flex:1; padding:10px; overflow:auto;"></div>

    <div style="display:flex;">
        <input id="admin-msg" style="flex:1;">
        <button onclick="sendAdmin()">Enviar</button>
    </div>

</div>

</div>

<script>
let currentSession = null;

function openChat(id){
    currentSession = id;
    loadMessages();
}

function loadMessages(){
    if(!currentSession) return;

    fetch('/admin/chat/messages/'+currentSession)
    .then(r=>r.json())
    .then(data=>{
        let box = document.getElementById('chat-box');
        box.innerHTML = '';

        data.forEach(m=>{
            let div = document.createElement('div');

            if(m.sender === 'admin'){
                div.style.textAlign = 'right';
                div.innerHTML = `<span style="background:#A86E63;color:#fff;padding:5px;border-radius:10px;">${m.message}</span>`;
            }else{
                div.innerHTML = `<span style="background:#eee;padding:5px;border-radius:10px;">${m.message}</span>`;
            }

            box.appendChild(div);
        });

        box.scrollTop = box.scrollHeight;
    });
}

function sendAdmin(){
    let msg = document.getElementById('admin-msg').value;

    fetch('/admin/chat/send',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            session_id: currentSession,
            message: msg
        })
    })
    .then(()=> {
        document.getElementById('admin-msg').value = '';
        loadMessages();
    });
}

// atualiza automático
setInterval(loadMessages, 3000);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\floriculturamaranata\resources\views/admin/chat/index.blade.php ENDPATH**/ ?>