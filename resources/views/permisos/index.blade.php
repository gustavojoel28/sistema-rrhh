@extends('layouts.app')

@section('content')

<h3><i class="bi bi-calendar2-check"></i> Solicitudes de Permisos</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-3 mb-3">
    <a href="{{ route('permisos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Solicitud
    </a>
</div>

<div class="card p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permisos as $permiso)
            <tr>
                <td>{{ $permiso->empleado->nombres }} {{ $permiso->empleado->apellidos }}</td>
                <td>{{ $permiso->tipo }}</td>
                <td>{{ $permiso->fecha_inicio }}</td>
                <td>{{ $permiso->fecha_fin }}</td>
                <td>
                    @if($permiso->estado == 'Pendiente')
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @elseif($permiso->estado == 'Aprobado')
                        <span class="badge bg-success">Aprobado</span>
                    @else
                        <span class="badge bg-danger">Rechazado</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('permisos.aprobar', $permiso->id) }}" class="btn btn-success btn-sm">Aprobar</a>
                    <a href="{{ route('permisos.rechazar', $permiso->id) }}" class="btn btn-danger btn-sm">Rechazar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $permisos->links() }}
</div>

@endsection
