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
            @foreach($permisos as $p)
            <tr>
                <td>{{ $p->empleado->nombres }} {{ $p->empleado->apellidos }}</td>
                <td>{{ $p->tipo }}</td>
                <td>{{ $p->fecha_inicio }}</td>
                <td>{{ $p->fecha_fin }}</td>
                <td>
                    @if($p->estado == 'Aprobado')
                        <span class="badge bg-success">Aprobado</span>
                    @elseif($p->estado == 'Rechazado')
                        <span class="badge bg-danger">Rechazado</span>
                    @elseif ($p->estado == 'Permiso')
                        <span class="badge bg-info">Permiso</span>
                    @else
                        <span class="badge bg-warning text-dark">{{ $p->estado }}</span>
                    @endif
                </td>
                <td>
                    {{-- 💡 CRÍTICO: Mostrar botones solo si el estado es Pendiente --}}
                    @if($p->estado == 'Pendiente')
                        {{-- Botón Aprobar --}}
                        <form action="{{ route('permisos.aprobar', $p) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Aprobar Permiso">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>

                        {{-- Botón Rechazar --}}
                        <form action="{{ route('permisos.rechazar', $p) }}" method="POST" class="d-inline ms-1">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" title="Rechazar Permiso" onclick="return confirm('¿Está seguro de rechazar este permiso?')">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    @endif

                    {{-- Historial (Si el empleado tiene muchos permisos) --}}
                    <a href="{{ route('permisos.historial', $p->empleado_id) }}" class="btn btn-sm btn-primary ms-1">
                        <i class="bi bi-clock-history"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $permisos->links() }}
</div>

@endsection
