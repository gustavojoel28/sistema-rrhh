@extends('layouts.app')

@section('content')

<h3><i class="bi bi-person-lines-fill"></i> Editar Empleado: {{ $empleado->nombres }} {{ $empleado->apellidos }}</h3>
<hr>

<div class="card p-4">
    <form action="{{ route('empleados.update', $empleado) }}" method="POST">
        @csrf
        @method('PUT') {{-- CRÍTICO: Usar el método PUT para actualizar --}}

        <div class="row">
            {{-- Columna Izquierda --}}
            <div class="col-md-6">

                {{-- DNI --}}
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni', $empleado->dni) }}" required>
                    @error('dni') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Nombres --}}
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres', $empleado->nombres) }}" required>
                    @error('nombres') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Apellidos --}}
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos', $empleado->apellidos) }}" required>
                    @error('apellidos') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}">
                    @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Teléfono --}}
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}">
                    @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Columna Derecha --}}
            <div class="col-md-6">

                {{-- Fecha de Nacimiento --}}
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento) }}">
                    @error('fecha_nacimiento') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Dirección --}}
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}">
                    @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Área --}}
                <div class="mb-3">
                    <label for="area_id" class="form-label">Área:</label>
                    <select class="form-select" id="area_id" name="area_id" required>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" @selected($area->id == old('area_id', $empleado->area_id))>
                                {{ $area->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Cargo --}}
                <div class="mb-3">
                    <label for="cargo_id" class="form-label">Cargo:</label>
                    <select class="form-select" id="cargo_id" name="cargo_id" required>
                        @foreach($cargos as $cargo)
                            <option value="{{ $cargo->id }}" @selected($cargo->id == old('cargo_id', $empleado->cargo_id))>
                                {{ $cargo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cargo_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Fecha de Ingreso --}}
                <div class="mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{ old('fecha_ingreso', $empleado->fecha_ingreso) }}" required>
                    @error('fecha_ingreso') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-save"></i> Guardar Cambios</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Cancelar</a>
    </form>
</div>

@endsection
