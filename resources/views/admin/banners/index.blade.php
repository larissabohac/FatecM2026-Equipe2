@extends('layouts.admin')

@section('content')
<h2>Banners da Home</h2>

<a href="{{ route('admin.banners.create') }}" class="btn btn-primary mb-3">
    Novo Banner
</a>

<table class="table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($banners as $banner)
            <tr>
                <td><img src="{{ asset('storage/'.$banner->image) }}" height="60"></td>
                <td>{{ $banner->active ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.banners.destroy',$banner) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection