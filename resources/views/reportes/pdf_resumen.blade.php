<!DOCTYPE html>
<html>
<head>
    <title>Reporte RRHH - {{ $anio }}-{{ $mes }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 0; padding: 0; }
        h1 { font-size: 16px; margin-bottom: 5px; }
        h2 { font-size: 12px; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; }
        .resumen { background-color: #e6f7ff; padding: 8px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #b3e6ff; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="header" style="text-align: center;">
        <h1>Municipalidad Distrital de Vice</h1>
        <p>Sistema de Gestión de Recursos Humanos (RRHH)</p>
        <p>Reporte Oficial: {{ \Carbon\Carbon::createFromDate($anio, $mes, 1)->isoFormat('MMMM YYYY') }}</p>
    </div>

    <h2>1. Resumen Financiero Agregado (Planilla)</h2>
    @if($reportePlanilla['resumen'] && $reportePlanilla['resumen']->total_empleados_pagados > 0)
        <div class="resumen">
            <strong>Empleados Pagados:</strong> {{ $reportePlanilla['resumen']->total_empleados_pagados }} |
            <strong>Total Ingresos:</strong> S/. {{ number_format($reportePlanilla['resumen']->suma_ingresos, 2) }} |
            <strong>Total Deducciones:</strong> S/. {{ number_format($reportePlanilla['resumen']->suma_deducciones, 2) }} |
            <strong>Sueldo Neto Total:</strong> S/. {{ number_format($reportePlanilla['resumen']->suma_neto, 2) }}
        </div>

        <h3 style="font-size: 11px;">Detalle por Empleado</h3>
        <table>
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Área / Cargo</th>
                    <th>Ingresos</th>
                    <th>Deducciones</th>
                    <th>Neto Pagado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportePlanilla['detalles'] as $d)
                <tr>
                    <td>{{ $d->empleado->nombres }} {{ $d->empleado->apellidos }}</td>
                    <td>{{ $d->empleado->area->nombre ?? 'N/A' }} / {{ $d->empleado->cargo->nombre ?? 'N/A' }}</td>
                    <td>{{ number_format($d->total_ingresos, 2) }}</td>
                    <td>{{ number_format($d->total_deducciones, 2) }}</td>
                    <td>{{ number_format($d->sueldo_neto, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se ha generado la planilla para este periodo.</p>
    @endif

    <div class="page-break"></div>

    <h2>2. Indicadores de Cumplimiento de Asistencia</h2>

    @if($reporteAsistencia['data']->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Horas Trab.</th>
                    <th>Tardanzas</th>
                    <th>Faltas</th>
                    <th>% Cumplimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reporteAsistencia['data'] as $r)
                <tr>
                    <td>{{ $r->empleado->nombres }} {{ $r->empleado->apellidos }}</td>
                    <td>{{ number_format($r->total_horas_trabajadas, 2) }}</td>
                    <td>{{ $r->total_tardanzas }}</td>
                    <td>{{ $r->total_faltas }}</td>
                    <td>
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
    @else
        <p>No hay registros de asistencia para este periodo.</p>
    @endif

    <div class="footer">
        Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>
