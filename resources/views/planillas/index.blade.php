@extends('layouts.app')

@section('content')

<h3><i class="bi bi-list-columns-reverse"></i> Planillas Generadas</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-end mb-3">
    {{-- Ruta para ir al formulario de generación --}}
    <a href="{{ route('planillas.create') }}" class="btn btn-success">
        <i class="bi bi-calculator"></i> Generar Nueva Planilla
    </a>
</div>

<div class="card p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mes y Año</th>
                <th>Total Empleados</th>
                <th>Sueldo Neto Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Muestra la lista de planillas agrupadas por mes_anio --}}
            @foreach($planillas as $planilla)
            <tr>
                <td>{{ \Carbon\Carbon::parse($planilla->mes_anio)->isoFormat('MMMM YYYY') }}</td>
                <td>{{ $planilla->total_empleados }}</td>
                <td>S/. {{ number_format($planilla->total_neto, 2) }}</td>
                <td>
                    {{-- Ruta para ver el detalle de ese mes --}}
                    <a href="{{ route('planillas.show', ['mes_anio' => $planilla->mes_anio]) }}" class="btn btn-sm btn-info text-white">
                        <i class="bi bi-eye"></i> Ver Detalle
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $planillas->links() }}
</div>

@endsection
