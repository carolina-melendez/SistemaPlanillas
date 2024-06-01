<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDescuento;

class TipoDescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_descuento= TipoDescuento::all();
        if ($tipo_descuento->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }
        return response()->json($tipo_descuento);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        return TipoDescuento::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipoDescuento = TipoDescuento::findOrFail($id);
        return response()->json($tipoDescuento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'sometimes|required|string|max:255',
        ]);

        $tipoDescuento = TipoDescuento::findOrFail($id);

        $tipoDescuento->update($request->all());

        return $tipoDescuento;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipoDescuento = TipoDescuento::findOrFail($id);
        $tipoDescuento->delete();

        return response()->noContent();
    }
}
