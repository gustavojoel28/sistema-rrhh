@extends('layouts.app')

@section('content')

<h3><i class="bi bi-file-earmark-plus"></i> Crear Solicitud de Permiso</h3>

<div class="card p-4">
    <form action="{{ route('permisos.store') }}" method="POST">
        @csrf

        <label>Empleado:</label>
        <select name="empleado_id" class="form-control" required>
            @foreach(\App\Models\Empleado::all() as $e)
                <option value="{{ $e->id }}">{{ $e->nombres }} {{ $e->apellidos }}</option>
            @endforeach
        </select>

        <label class="mt-2">Tipo:</label>
        <input type="text" name="tipo" class="form-control" required>

        <label class="mt-2">Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control" required>

        <label class="mt-2">Fecha Fin:</label>
        <input type="date" name="fecha_fin" class="form-control" required>

        <button class="btn btn-primary mt-3"><i class="bi bi-save"></i> Registrar</button>

    </form>
</div>

@endsection
