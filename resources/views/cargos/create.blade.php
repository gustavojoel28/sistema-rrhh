@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Cargo</h1>

    <form action="{{ route('cargos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Área</label>
            <select name="area_id" class="form-control" required>
                <option value="">Seleccione un área</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('cargos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
