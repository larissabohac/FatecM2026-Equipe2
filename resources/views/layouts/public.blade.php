<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Floricultura Maranata')</title>

    <!-- CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>
    
<body>

<header class="site-header">

<div class="topbar">
Entregamos amor em forma de flores
</div>

<div class="nav container">

<a href="/" class="logo">
Floricultura Maranata
</a>

<button class="menu-toggle" id="menuToggle">
<i class="fa fa-bars"></i>
</button>

<nav class="menu" id="menu">
<form action="{{ route('products.index') }}" method="GET" class="nav-search">

<input type="text"
name="search"
placeholder="Buscar flores..."
value="{{ request('search') }}">

<button type="submit">
<i class="fa fa-search"></i>
</button>

</form>

<a href="/">Home</a>
<a href="/produtos">Produtos</a>
<a href="/contato">Contato</a>

<a href="{{ route('cart.index') }}" class="cart-icon">
<i class="fa fa-shopping-cart"></i>
</a>

@auth
    @if(auth()->user()->role === 'admin')
        <a href="/admin/dashboard" class="user-icon">
            <i class="fa fa-user"></i>
        </a>
    @else
        <div style="display:flex; align-items:center; gap:10px;">

            <a href="/perfil" class="user-icon">
                <i class="fa fa-user"></i>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="
                    background:none;
                    border:none;
                    color:#8f5a5a;
                    cursor:pointer;
                ">
                    Sair
                </button>
            </form>

        </div>
    @endif
@else
    <a href="/login" class="user-icon">
        <i class="fa fa-user"></i>
    </a>
@endauth

</nav>

</div>

</header>

<main class="container">
@yield('content')
</main>

<footer class="site-footer">
<div class="container footer-top">

<div>
<h4>Floricultura Maranata</h4>
<p>Flores com carinho e elegância.</p><br>
<p>Av. Manoel Goular nº: 1125, centro Presidente Prudente - SP</p>
</div>

<div>
<h4>Contato</h4>
<p>FIXO: +55 (18)  3903-3917</p>
<p>Whatsapp: +55 (18) 99677-3917</p>
<p>Instagram: floricultura.maranata9</p>
</div>

</div>

<div class="footer-bottom">
© {{ date('Y') }} Floricultura Maranata
</div>

</footer>

<!-- MENU MOBILE -->
<script>
const toggle = document.getElementById("menuToggle");
const menu = document.getElementById("menu");

toggle.addEventListener("click", () => {
    menu.classList.toggle("active");
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ================= CHAT ================= -->

<div id="chat-btn" onclick="toggleChat()" style="
position:fixed;
bottom:20px;
right:20px;
width:60px;
height:60px;
background:#A86E63;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-size:24px;
z-index:999999;
cursor:pointer;
">
💬
</div>

<div id="chatbox" style="
display:none;
position:fixed;
bottom:90px;
right:20px;
width:300px;
background:white;
border-radius:10px;
box-shadow:0 0 15px rgba(0,0,0,0.2);
padding:10px;
z-index:999999;
">

    <b>Atendimento</b>

    <div id="messages" style="
        height:200px;
        overflow:auto;
        padding:10px;
    "></div>

    <input type="text" id="msg" placeholder="Digite..." style="width:100%; margin-top:5px;">
    <button onclick="sendMsg()" style="margin-top:5px;">Enviar</button>
</div>

<script>
window.toggleChat = function(){
    let chat = document.getElementById('chatbox');

    if(chat.style.display === 'none'){
        chat.style.display = 'block';
        loadChat();
    }else{
        chat.style.display = 'none';
    }
}

window.sendMsg = function(){
    let msg = document.getElementById('msg').value;

    if(msg.trim() === '') return;

    fetch('/chat',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body:JSON.stringify({message:msg})
    })
    .then(res=>res.json())
    .then(data=>{
        let box = document.getElementById('messages');

        let userMsg = document.createElement("div");
        userMsg.className = "msg-user";
        userMsg.innerText = "Você: " + msg;

        let botMsg = document.createElement("div");
        botMsg.className = "msg-bot";
        let texto = data.reply;

// força conversão e quebra
texto = texto.split('\\n').join('<br>');
texto = texto.split('\n').join('<br>');

botMsg.innerHTML = "Bot: " + texto;

        box.appendChild(userMsg);
        box.appendChild(botMsg);

        document.getElementById('msg').value = "";
        box.scrollTop = box.scrollHeight;
    })
    .catch(err => console.log(err));
}

// ENTER envia mensagem
document.getElementById("msg").addEventListener("keypress", function(e){
    if(e.key === "Enter"){
        sendMsg();
    }
});

function loadChat(){
    fetch('/chat/history')
    .then(res => res.json())
    .then(data => {
        let box = document.getElementById('messages');
        box.innerHTML = "";

        data.forEach(msg => {
            let div = document.createElement("div");

            if(msg.sender === 'user'){
                div.className = "msg-user";
                div.innerText = "Você: " + msg.message;
            }else{
                div.className = "msg-bot";
                div.innerHTML = "Bot: " + msg.message.replace(/\\n/g,"<br>");
            }

            box.appendChild(div);
        });
    });
}

function sendMsg(){
    let msg = document.getElementById('msg').value;

    fetch('/chat',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: msg })
    })
    .then(res=>res.json())
    .then(data=>{
        console.log(data);
    });
}

</script>

</body>
</html>