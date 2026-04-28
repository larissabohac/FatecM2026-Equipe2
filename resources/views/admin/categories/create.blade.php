@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold text-secondary">Novo Banner</h2>
        <p class="text-muted">As imagens devem ter preferencialmente 1920x600px.</p>
    </div>

    <div class="card shadow-sm border-0 col-md-8">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Arquivo de Imagem</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Título (Opcional)</label>
                        <input type="text" name="title" class="form-control" placeholder="Ex: Promoção Dia das Mães">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Link do Botão (URL)</label>
                        <input type="text" name="link" class="form-control" placeholder="https://...">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="active" class="form-select">
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-rosa-escuro px-4">
                        <i class="fas fa-upload me-2"></i>Publicar Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-light px-4">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection