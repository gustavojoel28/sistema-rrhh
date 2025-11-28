<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Area;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::with('area')->get();
        return view('cargos.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();
        return view('cargos.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable'
        ]);

        Cargo::create($request->all());

        return redirect()->route('cargos.index')->with('success', 'Cargo creado correctamente');

    }

    public function edit(Cargo $cargo)
    {
        $areas = Area::all();
        return view('cargos.edit', compact('cargo', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable'
        ]);

        $cargo->update($request->all());

        return redirect()->route('cargos.index')->with('success', 'Cargo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado');
    }
}
