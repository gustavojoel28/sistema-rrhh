@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cargo</h1>

    <form action="{{ route('cargos.update', $cargo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $cargo->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Área</label>
            <select name="area_id" class="form-control" required>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}"
                        {{ $cargo->area_id == $area->id ? 'selected' : '' }}>
                        {{ $area->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $cargo->descripcion }}</textarea>
        </div>

        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('cargos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
