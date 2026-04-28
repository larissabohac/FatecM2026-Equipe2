@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-secondary">Banners do Carrossel</h2>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-rosa-escuro">
            <i class="fas fa-plus me-2"></i>Novo Banner
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-vinho text-white">
                    <tr>
                        <th class="ps-4">Miniatura</th>
                        <th>Título / Link</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td class="ps-4 align-middle">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="img-thumbnail" style="width: 100px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="align-middle fw-semibold">
                            {{ $banner->title }}<br>
                            <small class="text-muted">{{ $banner->link ?? 'Sem link' }}</small>
                        </td>
                        <td class="align-middle">
                            <span class="badge {{ $banner->active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $banner->active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-warning border-0">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Excluir este banner?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection