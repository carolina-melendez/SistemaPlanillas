<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoDescuento;
use Illuminate\Http\Request;

class EmpleadoDescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleadoDescuentos = EmpleadoDescuento::with([
            'empleado',
            'tipoDescuento'
        ])->get();
        
        if ($empleadoDescuentos->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }

        return response()->json($empleadoDescuentos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_empleado' => 'required|exists:empleados,codigo_empleado',
            'tipo_descuento_id' => 'required|exists:tipo_descuentos,id_descuento',
            'monto' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $empleadoDescuento = EmpleadoDescuento::create($validated);
        return response()->json($empleadoDescuento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empleadoDescuento = EmpleadoDescuento::with([
            'empleado',
            'tipoDescuento'
        ])->find($id);

        if (is_null($empleadoDescuento)) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        return response()->json($empleadoDescuento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empleadoDescuento = EmpleadoDescuento::find($id);

        if (is_null($empleadoDescuento)) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'codigo_empleado' => 'required|exists:empleados,id',
            'tipo_descuento_id' => 'required|exists:tipos_descuento,id',
            'monto' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $empleadoDescuento->update($validatedData);
        return response()->json($empleadoDescuento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleadoDescuento = EmpleadoDescuento::find($id);

        if (is_null($empleadoDescuento)) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $empleadoDescuento->delete();
        return response()->json(['message' => 'Descuento eliminado con éxito']);
    }
}
