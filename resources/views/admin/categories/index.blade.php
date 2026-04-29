

@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Categorias</h2>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            + Nova Categoria
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            @if($categories->count())

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>

                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Deseja excluir esta categoria?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            @else

                <p>Nenhuma categoria cadastrada.</p>

            @endif

        </div>
    </div>

</div>

@endsection