@extends('layouts.admin')

@section('title','Admin - Produtos')

@section('content')
<div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center">
        <h1>Produtos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn">Novo Produto</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <table class="table" style="width:100%;margin-top:16px;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;">
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $p)
            <tr>

                <td style="width:120px">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" 
                             style="width:90px;height:60px;object-fit:cover;border-radius:6px"/>
                    @else
                        <div style="width:90px;height:60px;background:#efe6e5;border-radius:6px"></div>
                    @endif
                </td>

                <td>{{ $p->name }}</td>

                <td>
                    {{ $p->category->name ?? 'Sem categoria' }}
                </td>

                <td>
                    R$ {{ number_format($p->price, 2, ',', '.') }}
                </td>

                <td>{{ $p->stock }}</td>

                <td>
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm">
                        Editar
                    </a>

                    <form action="{{ route('admin.products.destroy', $p) }}" 
                          method="POST" 
                          style="display:inline-block"
                          onsubmit="return confirm('Remover este produto?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm" type="submit">
                            Remover
                        </button>

                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:18px">
        {{ $products->links() }}
    </div>
</div>
@endsection