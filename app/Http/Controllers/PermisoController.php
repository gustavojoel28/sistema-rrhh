<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Empleado;
use Illuminate\Http\Request;

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

    public function aprobar($id)
    {
        $permiso = Permiso::findOrFail($id);
        $permiso->update(['estado' => 'Aprobado']);

        return back()->with('success', 'El permiso fue aprobado.');
    }

    public function rechazar($id)
    {
        $permiso = Permiso::findOrFail($id);
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
