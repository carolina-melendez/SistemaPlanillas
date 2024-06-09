<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoIngreso;

class TipoIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoIngresos = TipoIngreso::all();
        if ($tipoIngresos->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }
        return response()->json($tipoIngresos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $tipoIngreso = TipoIngreso::create($validated);
        return response()->json($tipoIngreso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_ingreso)
    {
        $tipoIngreso = TipoIngreso::find($id_ingreso);
        if (!$tipoIngreso) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }
        return response()->json($tipoIngreso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $tipoIngreso = TipoIngreso::findOrFail($id);
        $tipoIngreso->update($validated);
        return response()->json($tipoIngreso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipoIngreso = TipoIngreso::findOrFail($id);
        $tipoIngreso->delete();
        return response()->json(null, 204);
    }
}
