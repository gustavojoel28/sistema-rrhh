<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::with('empleado')->latest()->paginate(10);
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('permisos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'tipo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Permiso::create([
            'empleado_id' => $request->empleado_id,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'Pendiente'
        ]);

        return redirect()->route('permisos.index')
            ->with('success', 'Solicitud registrada correctamente.');
    }

    public function aprobar(Permiso $permiso)
    {
        $permiso->update(['estado' => 'Aprobado']);

        $fechaInicio = Carbon::parse($permiso->fecha_inicio);
        $fechaFin = Carbon::parse($permiso->fecha_fin);
        // Itera sobre cada día cubierto por el permiso
        for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->addDay()) {

            $diaString = $fecha->toDateString();

            // Busca si ya existe un registro de asistencia para este empleado en esta fecha
            $asistencia = \App\Models\Asistencia::where('empleado_id', $permiso->empleado_id)
                ->where('fecha', $diaString)
                ->first();

            if ($asistencia) {
                // Si existe y tiene un estado de 'Falta' (o no tiene registro de entrada/salida)
                // Esto sobrescribe cualquier "Falta" registrada o automática.
                if ($asistencia->estado == 'Falta' || is_null($asistencia->hora_entrada)) {
                    $asistencia->update([
                        'estado' => 'Permiso',
                        'hora_entrada' => null,
                        'hora_salida' => null,
                    ]);
                }

            } else {
                // Si no existe, creamos el registro de 'Permiso' para que la Planilla lo contabilice
                \App\Models\Asistencia::create([
                    'empleado_id' => $permiso->empleado_id,
                    'fecha' => $diaString,
                    'hora_entrada' => null,
                    'hora_salida' => null,
                    'estado' => 'Permiso' // Nuevo estado
                ]);
            }
        }
        return back()->with('success', 'El permiso fue aprobado. Proceda con la gestión de Asistencia si es necesario.');
    }

    public function rechazar(Permiso $permiso)
    {
        $permiso->update(['estado' => 'Rechazado']);

        return back()->with('success', 'El permiso fue rechazado.');
    }

    public function historial($empleado_id)
    {
        $permisos = Permiso::where('empleado_id', $empleado_id)->get();
        $empleado = Empleado::findOrFail($empleado_id);

        return view('permisos.historial', compact('permisos', 'empleado'));
    }
}
