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

        <h2 style="text-align:center; color:#8f5a5a; margin-bottom:20px;">
            Redefinir senha
        </h2>

        <!-- ERROS -->
        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- TOKEN (OBRIGATÓRIO) -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- EMAIL -->
            <input type="email" name="email"
                value="{{ old('email', request()->email) }}"
                placeholder="Seu email"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin-bottom:15px;
                    border-radius:10px;
                    border:1px solid #ddd;
                ">

            <!-- NOVA SENHA -->
            <input type="password" name="password"
                placeholder="Nova senha"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin-bottom:15px;
                    border-radius:10px;
                    border:1px solid #ddd;
                ">

            <!-- CONFIRMAR -->
            <input type="password" name="password_confirmation"
                placeholder="Confirmar senha"
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
                Redefinir senha
            </button>

        </form>

    </div>

</div>

@endsection