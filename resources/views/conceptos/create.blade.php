@extends('layouts.app')

@section('content')

<h3><i class="bi bi-plus-circle"></i> Crear Concepto de Planilla</h3>

<div class="card p-4">
    <form action="{{ route('conceptos.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Nombre --}}
            <div class="mb-3 col-md-6">
                <label for="nombre" class="form-label">Nombre del Concepto:</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Tipo --}}
            <div class="mb-3 col-md-6">
                <label for="tipo" class="form-label">Tipo (Afecta a la planilla como):</label>
                <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="INGRESO" @selected(old('tipo') == 'INGRESO')>INGRESO (Suma)</option>
                    <option value="DEDUCCION" @selected(old('tipo') == 'DEDUCCION')>DEDUCCIÓN (Resta)</option>
                </select>
                @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            {{-- Cálculo --}}
            <div class="mb-3 col-md-6">
                <label for="calculo" class="form-label">Método de Cálculo:</label>
                <select class="form-select @error('calculo') is-invalid @enderror" id="calculo" name="calculo" required>
                    <option value="">Seleccione...</option>
                    <option value="FIJO" @selected(old('calculo') == 'FIJO')>Monto Fijo (Ej: Movilidad)</option>
                    <option value="PORCENTAJE" @selected(old('calculo') == 'PORCENTAJE')>Porcentaje (%) sobre el Sueldo (Ej: AFP)</option>
                    <option value="ASISTENCIA" @selected(old('calculo') == 'ASISTENCIA')>Basado en Asistencia (Ej: Descuento por Faltas)</option>
                    <option value="VARIABLE" @selected(old('calculo') == 'VARIABLE')>Variable (Se ingresa manualmente cada mes)</option>
                </select>
                @error('calculo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Valor --}}
            <div class="mb-3 col-md-6">
                <label for="valor" class="form-label">Valor (Monto fijo o decimal para %):</label>
                <input type="number" step="0.01" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ old('valor') }}">
                <small class="form-text text-muted">Para PORCENTAJE, ingrese en formato decimal (Ej: 0.13 para 13%). Dejar en blanco si es VARIABLE o ASISTENCIA.</small>
                @error('valor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-save"></i> Guardar Concepto</button>
        <a href="{{ route('conceptos.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Volver</a>
    </form>
</div>

@endsection
