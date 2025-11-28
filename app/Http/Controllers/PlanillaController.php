<?php

namespace App\Http\Controllers;

use App\Models\Planilla;
use App\Models\Empleado;
use App\Models\ConceptoPlanilla;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanillaController extends Controller
{
    // Muestra el listado de planillas ya generadas (por mes/año)
    public function index()
    {
        // Agrupar por mes y año
        $planillas = Planilla::selectRaw('mes_anio, count(empleado_id) as total_empleados, sum(sueldo_neto) as total_neto')
            ->groupBy('mes_anio')
            ->latest('mes_anio')
            ->paginate(10);

        return view('planillas.index', compact('planillas'));
    }

    // Muestra el detalle de una planilla por mes/año
    public function show($mes_anio)
    {
        $detalles = Planilla::with('empleado')->where('mes_anio', $mes_anio)->get();
        return view('planillas.show', compact('detalles', 'mes_anio'));
    }

    // Vista para seleccionar el mes y generar la planilla
    public function create()
    {
        return view('planillas.create');
    }

    // 💡 CRÍTICO: Lógica de Generación de Planilla
    public function generarPlanilla(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:' . (date('Y') - 5) . '|max:' . (date('Y') + 1)
        ]);

        $mesAnio = Carbon::createFromDate($request->anio, $request->mes, 1)->toDateString();

        // 1. Evitar duplicados
        if (Planilla::where('mes_anio', $mesAnio)->exists()) {
            return back()->with('error', 'La planilla para ese mes y año ya fue generada.');
        }

        $empleados = Empleado::where('estado', 'Activo')->get();
        $conceptos = ConceptoPlanilla::all();
        $diaLaboralStandard = 25; // Asumimos 25 días laborables efectivos por mes (típico Perú)

        foreach ($empleados as $empleado) {

            $sueldoBase = $empleado->sueldo_base ?? 0;
            $ingresos = $sueldoBase;
            $deducciones = 0;

            // Calcular días/horas trabajadas vs faltas
            // 💡 NOTA: Aquí se integrará la lógica de Asistencia
            // Este es un placeholder simple:
            $registroAsistencia = Asistencia::where('empleado_id', $empleado->id)
                ->whereYear('fecha', $request->anio)
                ->whereMonth('fecha', $request->mes)
                ->get();

            $diasFaltados = $registroAsistencia->where('estado', 'Falta')->count();
            $totalDiasTrabajados = $diaLaboralStandard - $diasFaltados;

            // Deducción por faltas (proporcional al sueldo base)
            $deduccionFaltas = ($sueldoBase / $diaLaboralStandard) * $diasFaltados;
            $deducciones += $deduccionFaltas;


            // Aplicar Conceptos (AFP, Bonos, etc.)
            foreach ($conceptos as $concepto) {
                $monto = 0;

                if ($concepto->calculo == 'FIJO') {
                    $monto = $concepto->valor;
                } elseif ($concepto->calculo == 'PORCENTAJE') {
                    // Se aplica el porcentaje al sueldo base proporcional (Sueldo Base - Faltas)
                    $sueldoProporcional = $sueldoBase - $deduccionFaltas;
                    $monto = $sueldoProporcional * $concepto->valor;
                }

                if ($concepto->tipo == 'INGRESO') {
                    $ingresos += $monto;
                } elseif ($concepto->tipo == 'DEDUCCION') {
                    $deducciones += $monto;
                }
            }

            // Crear el registro de Planilla
            Planilla::create([
                'empleado_id' => $empleado->id,
                'mes_anio' => $mesAnio,
                'total_ingresos' => $ingresos,
                'total_deducciones' => $deducciones,
                'sueldo_neto' => $ingresos - $deducciones,
                'estado' => 'Generada'
            ]);
        }

        return redirect()->route('planillas.index')->with('success', 'Planilla generada para ' . $mesAnio . ' correctamente.');
    }
}
