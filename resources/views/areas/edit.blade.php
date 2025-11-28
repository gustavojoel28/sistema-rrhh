@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Área</h1>

    <form action="{{ route('areas.update', $area) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $area->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $area->descripcion }}</textarea>
        </div>

        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
