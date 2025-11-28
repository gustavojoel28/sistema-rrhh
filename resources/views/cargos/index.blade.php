@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cargos</h1>

    <a href="{{ route('cargos.create') }}" class="btn btn-primary mb-3">Nuevo Cargo</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cargos as $cargo)
            <tr>
                <td>{{ $cargo->id }}</td>
                <td>{{ $cargo->nombre }}</td>
                <td>{{ $cargo->area->nombre }}</td>
                <td>{{ $cargo->descripcion }}</td>
                <td>
                    <a href="{{ route('cargos.edit', $cargo) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('cargos.destroy', $cargo) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('¿Seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
