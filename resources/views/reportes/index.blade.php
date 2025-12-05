@extends('layouts.app')

@section('content')

<h3><i class="bi bi-file-earmark-bar-graph"></i> Reportes e Indicadores RRHH</h3>

<div class="card p-4 mb-4">
    <h4>Filtros</h4>
    <form action="{{ route('reportes.index') }}" method="GET">
        <div class="row">
            {{-- Mes --}}
            <div class="mb-3 col-md-3">
                <label for="mes" class="form-label">Mes:</label>
                <select class="form-select" id="mes" name="mes" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" @selected($mes == $i)>
                            {{ \Carbon\Carbon::createFromDate(null, $i, 1)->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Año --}}
            <div class="mb-3 col-md-3">
                <label for="anio" class="form-label">Año:</label>
                <select class="form-select" id="anio" name="anio" required>
                    @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" @selected($anio == $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end mb-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i> Generar Reportes
                </button>
            </div>

            <div class="col-md-3 d-flex align-items-end mb-3">
                <a href="{{ route('reportes.pdf', ['mes' => $mes, 'anio' => $anio]) }}" class="btn btn-danger w-100" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ------------------------------------------------------------- --}}
{{-- REPORTE 1: INDICADORES DE CUMPLIMIENTO DE ASISTENCIA --}}
{{-- ------------------------------------------------------------- --}}
<div class="card p-4 mb-4">
    <h4><i class="bi bi-clock-history"></i> Reporte de Cumplimiento de Asistencia ({{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->isoFormat('MMMM YYYY') }})</h4>

    @if($reporteAsistencia['data']->isEmpty())
        <div class="alert alert-warning">No hay registros de asistencia para este periodo.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Horas Trabajadas</th>
                    <th>Tardanzas</th>
                    <th>Faltas</th>
                    <th>% Cumplimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reporteAsistencia['data'] as $r)
                <tr>
                    <td>{{ $r->empleado->nombres }} {{ $r->empleado->apellidos }}</td>
                    <td>{{ number_format($r->total_horas_trabajadas, 2) }} hrs.</td>
                    <td>{{ $r->total_tardanzas }} días</td>
                    <td>
                        <span class="badge {{ $r->total_faltas > 0 ? 'bg-danger' : 'bg-success' }}">
                            {{ $r->total_faltas }} días
                        </span>
                    </td>
                    <td>
                        {{-- Ejemplo de indicador simple: Faltas vs. Días del Mes (Necesita más lógica si solo contamos días laborables) --}}
                        @php
                            $diasEfectivos = $reporteAsistencia['dias_en_mes'] - $r->total_faltas;
                            $cumplimiento = ($diasEfectivos / $reporteAsistencia['dias_en_mes']) * 100;
                        @endphp
                        {{ number_format($cumplimiento, 1) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- ------------------------------------------------------------- --}}
{{-- REPORTE 2: RESUMEN DE PLANILLAS --}}
{{-- ------------------------------------------------------------- --}}
<div class="card p-4">
    <h4><i class="bi bi-cash-stack"></i> Resumen Agregado de Planilla</h4>

    @if($reportePlanilla['resumen'] && $reportePlanilla['resumen']->total_empleados_pagados > 0)
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="alert alert-info">
                    <h5>Total Empleados Pagados</h5>
                    <h2>{{ $reportePlanilla['resumen']->total_empleados_pagados }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-success">
                    <h5>Sueldo Neto Total</h5>
                    <h2>S/. {{ number_format($reportePlanilla['resumen']->suma_neto, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger">
                    <h5>Deducciones Totales</h5>
                    <h2>S/. {{ number_format($reportePlanilla['resumen']->suma_deducciones, 2) }}</h2>
                </div>
            </div>
        </div>

        <h5>Detalle por Empleado</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Ingresos</th>
                    <th>Deducciones</th>
                    <th>Neto Pagado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportePlanilla['detalles'] as $d)
                <tr>
                    <td>{{ $d->empleado->nombres }} {{ $d->empleado->apellidos }}</td>
                    <td>{{ number_format($d->total_ingresos, 2) }}</td>
                    <td>{{ number_format($d->total_deducciones, 2) }}</td>
                    <td>{{ number_format($d->sueldo_neto, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <div class="alert alert-warning">No se ha generado la planilla para {{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->isoFormat('MMMM YYYY') }}.</div>
    @endif
</div>

@endsection
