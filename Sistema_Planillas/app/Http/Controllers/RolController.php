<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = DB::table('roles')->get()->all();
        $data=[
            'roles'=>$roles,
            'status'=>200
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'permission' => 'required|array',
            'permission.*' => 'string|exists:permissions,name',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }
    
        // Verificar si el rol ya existe
        $existingRole = Role::where('name', $request->name)->where('guard_name', 'api')->first();
        if ($existingRole) {
            return response()->json([
                'message' => 'El rol ya existe',
                'status' => 400
            ], 400);
        }
    
        // Crear el rol con el guard 'api'
        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);
    
        // Obtener los IDs de los permisos
        $permissionIds = Permission::whereIn('name', $request->permission)->pluck('id')->toArray();
    
        if (empty($permissionIds)) {
            return response()->json([
                'message' => 'Permisos no encontrados',
                'status' => 404
            ], 404);
        }
    
        // Asignar los permisos al rol
        $role->syncPermissions($permissionIds);
    
        return response()->json([
            'message' => 'Rol creado con éxito',
            'status' => 201
        ], 201);
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $data=[
            'role'=>$role,
            'permissions'=>$permissions,
            'rolePermissions'=>$rolePermissions,
            'status'=>200
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $permissionIds = Permission::whereIn('name', $request->permission)->pluck('id')->toArray();
        // Asignar los permisos al rol
        $role->syncPermissions($permissionIds);

        $data = [
            'message' => 'Rol actualizado con éxito',
            'status' => 200
        ];

        return response()->json($data, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete($id);

        $data=[
            'message'=>'Rol eliminado con éxito',
            'status'=>204
        ];

        return response()->json($data, 204);
    }
}
