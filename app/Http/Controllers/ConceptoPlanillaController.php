<?php

namespace App\Http\Controllers;

use App\Models\ConceptoPlanilla;
use Illuminate\Http\Request;

class ConceptoPlanillaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Administrador RRHH');
    }
    public function index()
    {
        $conceptos = ConceptoPlanilla::all();
        return view('conceptos.index', compact('conceptos'));
    }

    public function create()
    {
        return view('conceptos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'tipo' => 'required|in:INGRESO,DEDUCCION',
            'calculo' => 'required|in:FIJO,PORCENTAJE,VARIABLE,ASISTENCIA',
            'valor' => 'nullable|numeric|min:0'
        ]);

        ConceptoPlanilla::create($request->all());

        return redirect()->route('conceptos.index')->with('success', 'Concepto creado correctamente.');
    }

    public function edit(ConceptoPlanilla $concepto)
    {
        return view('conceptos.edit', compact('concepto'));
    }

    public function update(Request $request, ConceptoPlanilla $concepto)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'tipo' => 'required|in:INGRESO,DEDUCCION',
            'calculo' => 'required|in:FIJO,PORCENTAJE,VARIABLE,ASISTENCIA',
            'valor' => 'nullable|numeric|min:0'
        ]);

        $concepto->update($request->all());

        return redirect()->route('conceptos.index')->with('success', 'Concepto actualizado.');
    }

    public function destroy(ConceptoPlanilla $concepto)
    {
        $concepto->delete();
        return redirect()->route('conceptos.index')->with('success', 'Concepto eliminado.');
    }
}
