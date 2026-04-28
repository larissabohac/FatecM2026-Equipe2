@extends('layouts.public')

@section('title', 'Contato')

@section('content')

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

@endsection
