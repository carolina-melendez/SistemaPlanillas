<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with([
            'tipoDocumento',
            'profesion',
            'estadoCivil',
            'paisDireccion',
            'departamento',
            'municipio',
            'cargo',
            'unidadOrganizativa',
            'jefe'
        ])->get();
        
        if ($empleados->isEmpty()) {
            return response()->json(['mensaje' => 'Sin registros ingresados'], 404);
        }

        return response()->json($empleados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'tercer_nombre' => 'nullable|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'apellido_de_casada' => 'nullable|string|max:255',
            'numero_documento' => 'required|string|unique:empleados,numero_documento|max:255',
            'tipo_documento_id' => 'required|exists:tipo_documentos,codigo',
            'fecha_nacimiento' => 'required|date',
            'numero_identificacion_tributaria' => 'required|string|size:14|unique:empleados,numero_identificacion_tributaria',
            'codigo_isss' => 'required|string|unique:empleados,codigo_isss|max:255',
            'codigo_nup' => 'required|string|unique:empleados,codigo_nup|max:255',
            'id_profesion' => 'required|exists:profesions,id_profesion',
            'id_estado_civil' => 'required|exists:estados_civiles,id_estado_civil',
            'direccion' => 'required|string',
            'pais_direccion_id' => 'required|exists:paises,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'codigo_cargo' => 'required|exists:cargo,codigo_cargo',
            'codigo_unidad' => 'required|exists:unidades_organizativas,codigo_unidad',
            'codigo_jefe' => 'nullable|exists:empleados,codigo_empleado',
            'correo_institucional' => 'required|string|email|max:255',
            'salario' => 'required|numeric|min:0',
            'status' => 'required|in:activo,inactivo',
            'sexo' => 'required|in:masculino,femenino',
            'fecha_contratacion' => 'required|date',
            'fecha_despido' => 'nullable|date',
            'correo_personal' => 'required|string|email|max:255',
            'telefono_contacto' => 'required|string',
        ]);

        $empleado = Empleado::create($validated);
        return response()->json($empleado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener un empleado por su código
        $empleado = Empleado::find($id);

        if (is_null($empleado)) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);

        if (is_null($empleado)) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'tercer_nombre' => 'nullable|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'apellido_de_casada' => 'nullable|string|max:255',
            'numero_documento' => 'required|string|max:255|unique:empleados,numero_documento,' . $empleado->codigo_empleado . ',codigo_empleado',
            'tipo_documento_id' => 'required|string|exists:tipo_documentos,codigo',
            'fecha_nacimiento' => 'required|date',
            'numero_identificacion_tributaria' => 'required|string|max:14|unique:empleados,numero_identificacion_tributaria,' . $empleado->codigo_empleado . ',codigo_empleado',
            'codigo_isss' => 'required|string|unique:empleados,codigo_isss,' . $empleado->codigo_empleado . ',codigo_empleado',
            'codigo_nup' => 'required|string|unique:empleados,codigo_nup,' . $empleado->codigo_empleado . ',codigo_empleado',
            'id_profesion' => 'required|exists:profesions,id_profesion',
            'id_estado_civil' => 'required|exists:estados_civiles,id_estado_civil',
            'direccion' => 'required|string',
            'pais_direccion_id' => 'required|exists:paises,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'codigo_cargo' => 'required|exists:cargo,codigo_cargo',
            'codigo_unidad' => 'required|exists:unidades_organizativas,codigo_unidad',
            'codigo_jefe' => 'nullable|exists:empleados,codigo_empleado',
            'correo_institucional' => 'required|string|email|max:255',
            'salario' => 'required|numeric',
            'status' => 'required|in:activo,inactivo',
            'sexo' => 'required|in:masculino,femenino',
            'fecha_contratacion' => 'required|date',
            'fecha_despido' => 'nullable|date',
            'correo_personal' => 'required|string|email|max:255',
            'telefono_contacto' => 'required|string',
        ]);

        $empleado->update($validatedData);
        return response()->json($empleado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Eliminar un empleado
        $empleado = Empleado::find($id);

        if (is_null($empleado)) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->delete();
        return response()->json(['message' => 'Empleado eliminado con éxito']);
    }
}
