@extends('layouts.public')

@section('title', 'Meu Perfil')

@section('content')

<div class="container" style="max-width:900px; margin-top:40px;">

    <h2 style="color:#8f5a5a; margin-bottom:20px;">
        Meu Perfil
    </h2>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-danger mb-3">
        Sair da conta
    </button>
</form>

    <!-- DADOS DO CLIENTE -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Dados pessoais</h5>

                <button onclick="toggleEdit()" class="btn btn-sm btn-outline-primary">
                    Editar
                </button>
            </div>

            <!-- VISUALIZAÇÃO -->
            <div id="viewMode">

                <p><strong>Nome:</strong> {{ $customer->name }}</p>

                @if($customer->type === 'fisica')
                    <p><strong>CPF:</strong> {{ $customer->cpf ?? '-' }}</p>
                @else
                    <p><strong>CNPJ:</strong> {{ $customer->cnpj ?? '-' }}</p>
                @endif

                <p><strong>Endereço:</strong>
                    {{ $customer->address }},
                    {{ $customer->number }} -
                    {{ $customer->city }}/{{ $customer->state }}
                </p>

                <p><strong>Telefone:</strong> {{ $customer->phone ?? '-' }}</p>

            </div>

            <!-- EDIÇÃO -->
            <form method="POST" action="{{ route('profile.update') }}" id="editMode" style="display:none;">
                @csrf

                <input type="text" name="name" class="form-control mb-2"
                    value="{{ $customer->name }}" placeholder="Nome">

                @if($customer->type === 'fisica')
                    <input type="text" name="cpf" class="form-control mb-2"
                        value="{{ $customer->cpf }}" placeholder="CPF">
                @else
                    <input type="text" name="cnpj" class="form-control mb-2"
                        value="{{ $customer->cnpj }}" placeholder="CNPJ">
                @endif

                <input type="text" name="address" class="form-control mb-2"
                    value="{{ $customer->address }}" placeholder="Endereço">

                <input type="text" name="number" class="form-control mb-2"
                    value="{{ $customer->number }}" placeholder="Número">

                <input type="text" name="city" class="form-control mb-2"
                    value="{{ $customer->city }}" placeholder="Cidade">

                <input type="text" name="state" class="form-control mb-2"
                    value="{{ $customer->state }}" placeholder="UF">

                <input type="text" name="phone" class="form-control mb-3"
                    value="{{ $customer->phone }}" placeholder="Telefone">

                <button class="btn btn-success w-100">
                    Salvar
                </button>
            </form>

        </div>
    </div>

    <!-- HISTÓRICO DE PEDIDOS -->
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Histórico de Pedidos</h5>

            @if($orders->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Nenhum pedido encontrado.</p>
            @endif

        </div>
    </div>

</div>

<script>
function toggleEdit() {
    let view = document.getElementById('viewMode');
    let edit = document.getElementById('editMode');

    view.style.display = view.style.display === 'none' ? 'block' : 'none';
    edit.style.display = edit.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection