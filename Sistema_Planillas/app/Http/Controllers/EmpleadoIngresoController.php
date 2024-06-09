<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoIngreso;

use Illuminate\Http\Request;

class EmpleadoIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleadoIngresos = EmpleadoIngreso::with([
            'empleado',
            'tipoIngreso'
        ])->get();

        if ($empleadoIngresos->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }

        return response()->json($empleadoIngresos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_empleado' => 'required|exists:empleados,codigo_empleado',
            'tipo_ingreso_id' => 'required|exists:tipo_ingresos,id_ingreso',
            'monto' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $empleadoIngreso = EmpleadoIngreso::create($validated);
        return response()->json($empleadoIngreso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empleadoIngreso = EmpleadoIngreso::with([
            'empleado',
            'tipoIngreso'
        ])->find($id);

        if (is_null($empleadoIngreso)) {
            return response()->json(['message' => 'Ingreso no encontrado'], 404);
        }

        return response()->json($empleadoIngreso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empleadoIngreso = EmpleadoIngreso::find($id);

        if (is_null($empleadoIngreso)) {
            return response()->json(['message' => 'Ingreso no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'codigo_empleado' => 'required|exists:empleados,codigo_empleado',
            'tipo_ingreso_id' => 'required|exists:tipo_ingresos,id_ingreso',
            'monto' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $empleadoIngreso->update($validatedData);
        return response()->json($empleadoIngreso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleadoIngreso = EmpleadoIngreso::find($id);

        if (is_null($empleadoIngreso)) {
            return response()->json(['message' => 'Ingreso no encontrado'], 404);
        }

        $empleadoIngreso->delete();
        return response()->json(['message' => 'Ingreso eliminado con éxito']);
    }
}
