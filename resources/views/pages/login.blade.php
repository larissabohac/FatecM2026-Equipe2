@extends('layouts.guest')

@section('title', 'Login - Floricultura Maranata')

@section('content')
<div class="login-page" style="margin:0 auto; box-shadow: 0px 8px 20px rgba(0,0,0,0.05);"> 
    <h2 class="login-title">Entrar</h2>

    <form method="POST" action="{{ url('/login') }}" class="login-form">
        @csrf

        <label>Email</label>
        <input type="email" name="email" placeholder="seuemail@exemplo.com" required autofocus>

        <label>Senha</label>
        <input type="password" name="password" placeholder="••••••••" required>

        <button type="submit" class="btn login-btn">Entrar</button>

        <p class="login-extra">Não tem conta? <a href="#">Criar conta</a></p>
    </form>
</div>
@endsection