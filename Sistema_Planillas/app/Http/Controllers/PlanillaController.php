<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Planilla;
use Illuminate\Support\Facades\DB;
use Exception;

class PlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planillas = Planilla::all();
        if ($planillas->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }
        return response()->json($planillas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $planilla = Planilla::create($validatedData);
        return response()->json($planilla, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $planilla = Planilla::find($id);
        if (is_null($planilla)) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }
        return response()->json($planilla);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'sometimes|required|date',
        ]);

        $planilla = Planilla::findOrFail($id);
        $planilla->update($validatedData);
        return response()->json($planilla);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $planilla = Planilla::findOrFail($id);
        $planilla->delete();
        return response()->json(null, 204);
    }

    public function buscarEmpleadosPorRango(Request $request)
    {
        try {
            // Obtener los parámetros de la solicitud
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $codigoUnidad = $request->input('codigo_unidad');

            // Validar los parámetros de entrada
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'codigo_unidad' => 'required|integer',
            ]);

            // Realizar la consulta SQL sin DB::raw()
            $empleados = DB::select("
                WITH SELECCION1 AS (
                    SELECT codigo_planilla FROM planilla
                    WHERE fecha_inicio = :fecha_inicio AND fecha_fin = :fecha_fin
                )
                SELECT 
                    A.codigo_empleado,
                    TRIM(COALESCE(D.primer_nombre,'')||' '||COALESCE(D.segundo_nombre,'')||' '||
                    COALESCE(D.tercer_nombre,'')||' '||COALESCE(D.apellido_paterno,'')||' '||
                    COALESCE(D.apellido_materno,'')||' '||COALESCE(D.apellido_de_casada,'')) as nombre_empleado,
                    A.salario salario_base_mensual,
                    A.total_ingresos ingresos_extras,
                    A.salario_bruto sub_total,
                    A.descuento_ISSS ISSS,
                    A.descuento_afp AFP,
                    A.descuento_renta RENTA,
                    A.total_descuentos_adicionales otros_descuentos,
                    A.salario_neto liquido_a_pagar
                FROM BOLETAPAGO A
                JOIN PLANILLA B ON A.codigo_planilla=B.codigo_planilla
                JOIN EMPLEADOS D ON A.codigo_empleado=D.codigo_empleado
                WHERE a.codigo_unidad = :codigo_unidad
            ", [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'codigo_unidad' => $codigoUnidad
            ]);

            // Verificar si se encontraron empleados
            if (empty($empleados)) {
                return response()->json(['error' => 'No se encontraron empleados para el rango de fechas y unidad especificados.'], 404);
            }

            return response()->json($empleados);
        } catch (Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error claro
            return response()->json(['error' => 'Ocurrió un error: ' . $e->getMessage()], 500);
        }
    }
}
