@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Empleado</h1>

    <form action="{{ route('empleados.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>DNI</label>
                <input type="text" name="dni" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Nombres</label>
                <input type="text" name="nombres" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Apellidos</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Correo</label>
                <input type="email" name="correo" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Área</label>
                <select name="area_id" class="form-control" required>
                    <option value="">Seleccione un área</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Cargo</label>
                <select name="cargo_id" class="form-control" required>
                    <option value="">Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" required>
            </div>

        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
