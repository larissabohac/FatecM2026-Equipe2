@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">🖼 Criar Novo Banner</h2>

    {{-- Mensagens de erro --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Ocorreram erros:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.banners.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="row">

                    <!-- Título -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Título do Banner</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="Ex: Promoção de Rosas"
                               value="{{ old('title') }}">
                    </div>

                    <!-- Posição -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Posição</label>
                        <input type="number"
                               name="position"
                               class="form-control"
                               value="{{ old('position', 1) }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="active"
                                   class="form-check-input"
                                   checked>
                            <label class="form-check-label">
                                Banner Ativo
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Link -->
                <div class="mb-3">
                    <label class="form-label">Link (opcional)</label>
                    <input type="text"
                           name="link"
                           class="form-control"
                           placeholder="https://seusite.com/promocao"
                           value="{{ old('link') }}">
                </div>

                <!-- Upload -->
                <div class="mb-3">
                    <label class="form-label">Imagem do Banner *</label>

                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*"
                           onchange="previewImage(event)"
                           required>

                    <small class="text-muted">
                        Tamanho recomendado: 1200x400px
                    </small>
                </div>

                <!-- Preview da imagem -->
                <div class="mb-3">
                    <img id="preview"
                         style="max-width:100%; display:none;"
                         class="img-fluid rounded border">
                </div>

                <!-- Botões -->
                <div class="d-flex gap-2">

                    <button class="btn btn-success">
                        💾 Salvar Banner
                    </button>

                    <a href="{{ route('admin.banners.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </div>
        </div>

    </form>

</div>

<script>
function previewImage(event)
{
    const reader = new FileReader();

    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };

    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection