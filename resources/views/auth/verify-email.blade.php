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
        max-width:420px;
        background:white;
        padding:30px;
        border-radius:16px;
        box-shadow:0px 8px 25px rgba(0,0,0,0.08);
        text-align:center;
    ">

        <h2 style="color:#8f5a5a; margin-bottom:15px;">
            Verifique seu email 📩
        </h2>

        <p style="font-size:14px; color:#666; margin-bottom:20px;">
            Enviamos um link de verificação para o seu email.
            Clique nele para ativar sua conta.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div style="color:green; margin-bottom:15px;">
                Novo link enviado com sucesso!
            </div>
        @endif

        <!-- REENVIAR -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit"
                style="
                    width:100%;
                    background:#b57b7b;
                    color:white;
                    padding:12px;
                    border:none;
                    border-radius:10px;
                    margin-bottom:10px;
                ">
                Reenviar email
            </button>
        </form>

        <!-- SAIR -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                style="
                    background:none;
                    border:none;
                    color:#8f5a5a;
                    cursor:pointer;
                    font-size:14px;
                ">
                Sair
            </button>
        </form>

    </div>

</div>

@endsection