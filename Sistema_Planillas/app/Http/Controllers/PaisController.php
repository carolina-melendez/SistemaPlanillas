<?php

namespace App\Http\Controllers;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paises = Pais::all();
        if ($paises->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }
        return response()->json($paises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $pais = Pais::create($validated);
        return response()->json($pais, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pais)
    {
        $pais = Pais::find($id_pais);
        return response()->json($pais);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $pais = Pais::findOrFail($id);

        $pais->update($validated);
        return response()->json($pais);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pais $pais)
    {
        $pais->delete();
        return response()->json(null, 204);
    }
}
