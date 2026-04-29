@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">Clientes</h2>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Pedidos</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->orders_count }}</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection