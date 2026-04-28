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
            Confirme sua senha
        </h2>

        <p style="font-size:14px; color:#666; text-align:center; margin-bottom:20px;">
            Esta é uma área segura. Digite sua senha para continuar.
        </p>

        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <input type="password" name="password" placeholder="Digite sua senha"
                required
                style="
                    width:100%;
                    padding:12px;
                    border-radius:10px;
                    border:1px solid #ddd;
                    margin-bottom:15px;
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
                Confirmar
            </button>

        </form>

    </div>

</div>

@endsection