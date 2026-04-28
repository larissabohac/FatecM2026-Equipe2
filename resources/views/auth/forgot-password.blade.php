@extends('layouts.guest')

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

        <h2 style="text-align:center; color:#8f5a5a; margin-bottom:15px;">
            Recuperar senha
        </h2>

        <p style="font-size:14px; color:#666; text-align:center; margin-bottom:20px;">
            Digite seu email e enviaremos um link para redefinir sua senha.
        </p>

        <!-- SUCESSO -->
        @if (session('status'))
            <div style="color:green; margin-bottom:15px;">
                {{ session('status') }}
            </div>
        @endif

        <!-- ERRO -->
        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <input type="email" name="email"
                value="{{ old('email') }}"
                placeholder="Seu email"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin-bottom:15px;
                    border-radius:10px;
                    border:1px solid #ddd;
                ">

            <button type="submit"
                style="
                    width:100%;
                    background:#b57b7b;
                    color:white;
                    padding:12px;
                    border:none;
                    border-radius:10px;
                ">
                Enviar link de recuperação
            </button>

        </form>

        <div style="text-align:center; margin-top:15px;">
            <a href="{{ route('login') }}" style="color:#b57b7b;">
                Voltar ao login
            </a>
        </div>

    </div>

</div>

@endsection