@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">Controle de Estoque</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Entrada</th>
                <th>Saída</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>
                        {{ $product->stock }}

                        @if($product->stock <= 5)
                            <span class="badge bg-danger">Baixo</span>
                        @endif
                    </td>

                    <td style="width:180px">
                        <form method="POST" action="{{ route('admin.stock.add', $product->id) }}">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="quantity" min="1" class="form-control">
                                <button class="btn btn-success btn-sm">+</button>
                            </div>
                        </form>
                    </td>

                    <td style="width:180px">
                        <form method="POST" action="{{ route('admin.stock.remove', $product->id) }}">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="quantity" min="1" class="form-control">
                                <button class="btn btn-danger btn-sm">−</button>
                            </div>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection