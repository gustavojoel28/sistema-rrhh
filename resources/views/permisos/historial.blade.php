@extends('layouts.app')

@section('content')

<h3><i class="bi bi-clock-history"></i> Historial de Permisos de {{ $empleado->nombres }}</h3>

<div class="card p-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permisos as $permiso)
            <tr>
                <td>{{ $permiso->tipo }}</td>
                <td>{{ $permiso->fecha_inicio }}</td>
                <td>{{ $permiso->fecha_fin }}</td>
                <td>{{ $permiso->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
