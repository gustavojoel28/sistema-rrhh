@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Empleados</h1>

    <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">Nuevo Empleado</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre Completo</th>
                <th>Área</th>
                <th>Cargo</th>
                <th>Ingreso</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
            <tr>
                <td>{{ $empleado->dni }}</td>
                <td>{{ $empleado->nombres }} {{ $empleado->apellidos }}</td>
                <td>{{ $empleado->area->nombre }}</td>
                <td>{{ $empleado->cargo->nombre }}</td>
                <td>{{ $empleado->fecha_ingreso }}</td>
                <td>{{ $empleado->estado ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Seguro?')" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
