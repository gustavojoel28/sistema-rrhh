<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Area;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with(['area', 'cargo'])->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();
        $cargos = Cargo::all();
        return view('empleados.create', compact('areas', 'cargos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|size:8|unique:empleados',
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'nullable|email|unique:empleados',
            'telefono' => 'nullable',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable',
            'area_id' => 'required|exists:areas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'fecha_ingreso' => 'required|date',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente');
    }

    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'dni' => 'required|size:8|unique:empleados,dni,' . $empleado->id,
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'nullable|email|unique:empleados,correo,' . $empleado->id,
            'telefono' => 'nullable',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable',
            'area_id' => 'required|exists:areas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado');
    }
}
