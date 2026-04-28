@extends('layouts.guest')

@section('title', 'Login - Floricultura Maranata')

@section('content')
<div style="
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
">

    <div style="
        width:100%;
        max-width:400px;
        background:white;
        padding:30px;
        border-radius:16px;
        box-shadow:0px 8px 25px rgba(0,0,0,0.08);
    ">

        <h2 style="text-align:center; color:#8f5a5a; margin-bottom:20px;">
            Entrar na conta
        </h2>



    <form method="POST" action="{{ url('/login') }}" class="login-form">
        @csrf

        <label>Email</label>
        <input type="email" name="email" placeholder="seuemail@exemplo.com" 
        style="width:100%; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;"required>

        <label>Senha</label>
        <input type="password" name="password" placeholder="••••••••" style="width:100%; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;"
         required>

        <button type="submit" style="
                    width:100%;
                    background:#b57b7b;
                    color:white;
                    padding:12px;
                    border:none;
                    border-radius:10px;
                ">Entrar</button>

        <p class="login-extra"style="text-align:center; margin-top:15px;">Não tem conta? <a href="{{ route('register') }}">Criar conta</a></p>
    </form>

</div>

@endsection
