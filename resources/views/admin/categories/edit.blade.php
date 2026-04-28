@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold text-secondary">Editar Banner</h2>
    </div>

    <div class="card shadow-sm border-0 col-md-8">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Imagem Atual</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                        <label class="form-label fw-bold">Substituir Imagem (Deixe vazio para manter)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Título</label>
                        <input type="text" name="title" value="{{ $banner->title }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Link</label>
                        <input type="text" name="link" value="{{ $banner->link }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="active" class="form-select">
                            <option value="1" {{ $banner->active ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ !$banner->active ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-rosa-escuro px-4">
                        <i class="fas fa-save me-2"></i>Atualizar Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-light px-4">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection