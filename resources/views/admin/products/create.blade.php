@extends('layouts.admin')

@section('title','Admin - Novo Produto')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Novo Produto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-dark text-white">
                Dados do Produto
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nome</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Categoria</label>

                        <select name="category_id" class="form-select">
                            <option value="">Selecione...</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text"
                               name="slug"
                               class="form-control"
                               value="{{ old('slug') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Preço</label>
                        <input type="text"
                               name="price"
                               class="form-control"
                               value="{{ old('price') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Estoque</label>
                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock',0) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Imagem</label>
                        <input type="file"
                               name="image"
                               class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Descrição</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">

                        <div class="form-check">
                            <input type="checkbox"
                                   name="featured"
                                   value="1"
                                   class="form-check-input">

                            <label class="form-check-label">
                                Produto em destaque
                            </label>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success btn-lg">
                    ✔ Criar Produto
                </button>
            </div>

        </div>

    </form>

</div>

@endsection