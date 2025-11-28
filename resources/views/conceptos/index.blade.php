
@extends('layouts.app')

@section('content')

<h3><i class="bi bi-gear"></i> Configuración de Conceptos de Planilla</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('conceptos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Concepto
    </a>
</div>

<div class="card p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cálculo</th>
                <th>Valor / Porcentaje</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->nombre }}</td>
                <td>
                    @if($c->tipo == 'INGRESO')
                        <span class="badge bg-success">{{ $c->tipo }}</span>
                    @else
                        <span class="badge bg-danger">{{ $c->tipo }}</span>
                    @endif
                </td>
                <td>{{ $c->calculo }}</td>
                <td>{{ $c->valor ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('conceptos.edit', $c) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('conceptos.destroy', $c) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este concepto?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
