@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Editar Categoria</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.categories.update', $category->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nome da Categoria</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">
                        Atualizar
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-secondary">
                        Voltar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection