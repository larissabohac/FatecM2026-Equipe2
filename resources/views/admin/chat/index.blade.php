@extends('admin.layout')

@section('content')

<div style="display:flex; height:80vh;">

<!-- LISTA DE SESSÕES -->
<div style="width:30%; border-right:1px solid #ccc; overflow:auto;">
    @foreach($sessions as $s)
        <div onclick="openChat({{ $s->id }})"
             style="padding:10px; cursor:pointer; border-bottom:1px solid #eee;">
            Chat #{{ $s->id }}
        </div>
    @endforeach
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

@endsection