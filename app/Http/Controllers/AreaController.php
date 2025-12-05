<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        // Solo permite el acceso al rol 'Administrador RRHH'
        $this->middleware('role:Administrador RRHH');
    }

    public function index()
    {
        $areas = Area::all();
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:areas|max:100',
            'descripcion' => 'nullable'
        ]);

        Area::create($request->all());

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente');
    }

    public function edit(Area $area)
    {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre,' . $area->id,
            'descripcion' => 'nullable'
        ]);

        $area->update($request->all());

        return redirect()->route('areas.index')->with('success', 'Área actualizada');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Área eliminada');
    }
}
