@extends('layouts.app')

@section('content')

<h3><i class="bi bi-calculator"></i> Generar Planilla Mensual</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card p-4">
    <p>Seleccione el mes y año para el cual desea generar la planilla de todos los empleados activos. Este proceso es irreversible para el mes seleccionado.</p>

    <form action="{{ route('planillas.generar') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Mes --}}
            <div class="mb-3 col-md-4">
                <label for="mes" class="form-label">Mes:</label>
                <select class="form-select @error('mes') is-invalid @enderror" id="mes" name="mes" required>
                    <option value="">Seleccione Mes...</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" @selected(old('mes', date('n')) == $i)>
                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                        </option>
                    @endfor
                </select>
                @error('mes') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Año --}}
            <div class="mb-3 col-md-4">
                <label for="anio" class="form-label">Año:</label>
                <select class="form-select @error('anio') is-invalid @enderror" id="anio" name="anio" required>
                    <option value="">Seleccione Año...</option>
                    @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" @selected(old('anio', date('Y')) == $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('anio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 d-flex align-items-end mb-3">
                <button type="submit" class="btn btn-success w-100" onclick="return confirm('ADVERTENCIA: ¿Confirma que desea generar la planilla para el mes seleccionado? Esto es irreversible.')">
                    <i class="bi bi-lightning-charge"></i> Generar Planilla
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
