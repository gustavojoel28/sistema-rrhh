<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    // LISTAR ASISTENCIAS
    public function index()
    {
        $asistencias = Asistencia::with('empleado')->latest()->paginate(10);
        return view('asistencias.index', compact('asistencias'));
    }

    // MARCAR ENTRADA
    public function marcarEntrada(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id'
        ]);

        $hoy = Carbon::today()->toDateString();

        // Evitar duplicado
        if (Asistencia::where('empleado_id', $request->empleado_id)->where('fecha', $hoy)->exists()) {
            return back()->with('error', 'La entrada ya fue registrada hoy.');
        }

        // Regla automática tardanza
        $horaActual = Carbon::now();
        $estado = $horaActual->gt(Carbon::parse('08:15:00')) ? 'Tardanza' : 'Presente';

        Asistencia::create([
            'empleado_id' => $request->empleado_id,
            'fecha' => $hoy,
            'hora_entrada' => $horaActual->format('H:i:s'),
            'estado' => $estado
        ]);

        return back()->with('success', 'Entrada registrada correctamente.');
    }

    // MARCAR SALIDA
    public function marcarSalida(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id'
        ]);

        $hoy = Carbon::today()->toDateString();

        $registro = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $hoy)
            ->first();

        if (!$registro) {
            return back()->with('error', 'Primero debe marcar la entrada.');
        }

        if ($registro->hora_salida) {
            return back()->with('error', 'La salida ya fue registrada.');
        }

        $registro->update([
            'hora_salida' => Carbon::now()->format('H:i:s')
        ]);

        return back()->with('success', 'Salida registrada correctamente.');
    }
}
