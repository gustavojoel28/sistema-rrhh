<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Asistencia;
use App\Models\Planilla;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class ReporteController extends Controller
{
    public function exportarPDF(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        // Reutilizamos la lógica para obtener los datos
        $reporteAsistencia = $this->generarReporteAsistencia($mes, $anio);
        $reportePlanilla = $this->generarReportePlanilla($mes, $anio);

        // 1. Cargar la vista específica para PDF
        $pdf = Pdf::loadView('reportes.pdf_resumen', compact(
            'reporteAsistencia',
            'reportePlanilla',
            'mes',
            'anio'
        ));

        // 2. Descargar el archivo con un nombre descriptivo
        $nombreArchivo = 'Reporte_RRHH_' . $anio . '_' . $mes . '.pdf';

        return $pdf->download($nombreArchivo);
    }
    // Muestra la vista principal de reportes con opciones de filtro
    public function index(Request $request)
    {
        $empleados = Empleado::select('id', 'nombres', 'apellidos')->get();
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        $reporteAsistencia = $this->generarReporteAsistencia($mes, $anio);
        $reportePlanilla = $this->generarReportePlanilla($mes, $anio);

        return view('reportes.index', compact(
            'empleados',
            'reporteAsistencia',
            'reportePlanilla',
            'mes',
            'anio'
        ));
    }

    // Lógica para el Reporte de Cumplimiento de Asistencia
    private function generarReporteAsistencia($mes, $anio)
    {
        $fechaInicio = Carbon::createFromDate($anio, $mes, 1)->startOfDay();
        $fechaFin = Carbon::createFromDate($anio, $mes)->endOfMonth()->startOfDay();

        // 1. Obtener la data de Asistencia para el periodo
        $data = Asistencia::selectRaw('
            empleado_id,
            sum(case when estado = "Tardanza" then 1 else 0 end) as total_tardanzas,
            sum(case when estado = "Falta" then 1 else 0 end) as total_faltas,
            sum(duracion) as total_horas_trabajadas
        ')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->groupBy('empleado_id')
        ->with('empleado')
        ->get();

        // 2. Calcular el total de días calendario en el mes
        $diasEnMes = $fechaInicio->daysInMonth;

        return [
            'data' => $data,
            'dias_en_mes' => $diasEnMes
        ];
    }

    // Lógica para el Reporte de Resumen de Planilla
    private function generarReportePlanilla($mes, $anio)
    {
        $mesAnio = Carbon::createFromDate($anio, $mes, 1)->toDateString();

        // 1. Obtener la data de Planilla para el mes específico
        $data = Planilla::where('mes_anio', $mesAnio)
            ->selectRaw('
                sum(total_ingresos) as suma_ingresos,
                sum(total_deducciones) as suma_deducciones,
                sum(sueldo_neto) as suma_neto,
                count(id) as total_empleados_pagados
            ')
            ->first();

        // 2. Obtener el detalle de la planilla (solo si la data existe)
        $detalles = Planilla::with('empleado')->where('mes_anio', $mesAnio)->get();

        return [
            'resumen' => $data,
            'detalles' => $detalles
        ];
    }


}
