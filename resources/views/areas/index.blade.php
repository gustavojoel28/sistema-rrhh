@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Áreas</h1>

    <a href="{{ route('areas.create') }}" class="btn btn-primary mb-3">Nueva Área</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($areas as $area)
            <tr>
                <td>{{ $area->id }}</td>
                <td>{{ $area->nombre }}</td>
                <td>{{ $area->descripcion }}</td>
                <td>
                    <a href="{{ route('areas.edit', $area) }}" class="btn btn-warning">Editar</a>

                    <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline">
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
