<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfesionController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\EstadoCivilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\OrganizacionController;
use App\Http\Controllers\UnidadOrganizativaController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\TipoDescuentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProfesionController;
use App\Models\TipoDocumento;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoDescuentoController;
use App\Http\Controllers\EmpleadoIngresoController;
use App\Http\Controllers\PlanillaController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/password_reset', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
    });
});


Route::group(['middleware' => ['auth:api', 'role:Administrador']], function () {



    //Rutas para cargos
    //Route::get('/cargo', [CargoController::class, 'index']);
    //Route::get('/cargo/{cargo}', [CargoController::class, 'show']);
    //Route::post('/cargo', [CargoController::class, 'store']);
    //Route::put('/cargo/{id}', [CargoController::class, 'update']);
    //Route::patch('/cargo/{id}', [CargoController::class, 'update']);
    //Route::delete('/cargo/{id}', [CargoController::class, 'destroy']);

    //Rutas para rol

});

// Rutas para roles
Route::get('/rol', [RolController::class, 'index']);
Route::get('/rol/{rol}', [RolController::class, 'show']);
Route::post('/rol', [RolController::class, 'store']);
Route::put('/rol/{id}', [RolController::class, 'update']);
Route::patch('/rol/{id}', [RolController::class, 'update']);
Route::delete('/rol/{id}', [RolController::class, 'destroy']);

//Rutas para profesiones
Route::get('/profesion', [ProfesionController::class, 'index']);
Route::get('/profesion/{id}', [ProfesionController::class, 'show']);
Route::post('/profesion', [ProfesionController::class, 'store']);
Route::put('/profesion/{id}', [ProfesionController::class, 'update']);
Route::patch('/profesion/{id}', [ProfesionController::class, 'update']);
Route::delete('/profesion/{id}', [ProfesionController::class, 'destroy']);

//Rutas para estado civil
Route::get('/estados_civiles', [EstadoCivilController::class, 'index']);
Route::get('/estados_civiles/{estadoCivil}', [EstadoCivilController::class, 'show']);
Route::post('/estados_civiles', [EstadoCivilController::class, 'store']);
Route::put('/estados_civiles/{id}', [EstadoCivilController::class, 'update']);
Route::patch('/estados_civiles/{id}', [EstadoCivilController::class, 'update']);
Route::delete('/estados_civiles/{id}', [EstadoCivilController::class, 'destroy']);

//Rutas para pais
Route::get('/pais', [PaisController::class, 'index']);
Route::get('/pais/{pais}', [PaisController::class, 'show']);
Route::post('/pais', [PaisController::class, 'store']);
Route::put('/pais/{id}', [PaisController::class, 'update']);
Route::patch('/pais/{id}', [PaisController::class, 'update']);
Route::delete('/pais/{id}', [PaisController::class, 'destroy']);

//Rutas para departamento
Route::get('/departamento', [DepartamentoController::class, 'index']);
Route::get('/departamento/{departamento}', [DepartamentoController::class, 'show']);
Route::post('/departamento', [DepartamentoController::class, 'store']);
Route::put('/departamento/{id}', [DepartamentoController::class, 'update']);
Route::patch('/departamento/{id}', [DepartamentoController::class, 'update']);
Route::delete('/departamento/{id}', [DepartamentoController::class, 'destroy']);

//Rutas para departamento
Route::get('/municipio', [MunicipioController::class, 'index']);
Route::get('/municipio/{municipio}', [MunicipioController::class, 'show']);
Route::post('/municipio', [MunicipioController::class, 'store']);
Route::put('/municipio/{id}', [MunicipioController::class, 'update']);
Route::patch('/municipio/{id}', [MunicipioController::class, 'update']);
Route::delete('/municipio/{id}', [MunicipioController::class, 'destroy']);



//rutas para TipoDescuento
Route::get('/tipo_descuento', [TipoDescuentoController::class, 'index']);
Route::get('/tipo_descuento/{id}', [TipoDescuentoController::class, 'show']);
Route::post('/tipo_descuento', [TipoDescuentoController::class, 'store']);
Route::put('/tipo_descuento/{id}', [TipoDescuentoController::class, 'update']);
Route::patch('/tipo_descuento/{id}', [TipoDescuentoController::class, 'update']);
Route::delete('/tipo_descuento/{id}', [TipoDescuentoController::class, 'destroy']);

//rutas para Empleado
Route::get('/empleado', [EmpleadoController::class, 'index']);
Route::get('/empleado/{id}', [EmpleadoController::class, 'show']);
Route::post('/empleado', [EmpleadoController::class, 'store']);
Route::put('/empleado/{codigo_empleado}', [EmpleadoController::class, 'update']);
Route::patch('/empleado/{id}', [EmpleadoController::class, 'update']);
Route::delete('/empleado/{id}', [EmpleadoController::class, 'destroy']);

//Rutas para cargos
Route::get('/cargo', [CargoController::class, 'index']);
Route::get('/cargo/{cargo}', [CargoController::class, 'show']);
Route::post('/cargo', [CargoController::class, 'store']);
Route::put('/cargo/{codigo_cargo}', [CargoController::class, 'update']);
Route::patch('/cargo/{id}', [CargoController::class, 'update']);
Route::delete('/cargo/{id}', [CargoController::class, 'destroy']);


//Rutas para organizacion
Route::get('/organizacion', [OrganizacionController::class, 'index']);
Route::get('/organizacion/{organizacion}', [OrganizacionController::class, 'show']);
Route::post('/organizacion', [OrganizacionController::class, 'store']);
Route::put('/organizacion/{id}', [OrganizacionController::class, 'update']);
Route::patch('/organizacion/{id}', [OrganizacionController::class, 'update']);
Route::delete('/organizacion/{id}', [OrganizacionController::class, 'destroy']);

//Rutas para organizacion
Route::get('/unidad', [UnidadOrganizativaController::class, 'index']);
Route::get('/unidad/{unidad}', [UnidadOrganizativaController::class, 'show']);
Route::post('/unidad', [UnidadOrganizativaController::class, 'store']);
Route::put('/unidad/{id}', [UnidadOrganizativaController::class, 'update']);
Route::patch('/unidad/{id}', [UnidadOrganizativaController::class, 'update']);
Route::delete('/unidad/{id}', [UnidadOrganizativaController::class, 'destroy']);

//Rutas para presupuesto
Route::get('/presupuesto_unidad', [PresupuestoController::class, 'index']);
Route::get('/presupuesto_unidad/{unidad}', [PresupuestoController::class, 'show']);
Route::post('/presupuesto_unidad', [PresupuestoController::class, 'store']);
Route::put('/presupuesto_unidad/{id}', [PresupuestoController::class, 'update']);
Route::patch('/presupuesto_unidad/{id}', [PresupuestoController::class, 'update']);
Route::delete('/presupuesto_unidad/{id}', [PresupuestoController::class, 'destroy']);

//Rutas para Tipo_Documento
Route::get('/tipo_documento', [TipoDocumentoController::class, 'index']);
Route::get('/tipo_documento/{id}', [TipoDocumentoController::class, 'show']);
Route::post('/tipo_documento', [TipoDocumentoController::class, 'store']);
Route::put('/tipo_documento{id}', [TipoDocumentoController::class, 'update']);
Route::patch('/tipo_documento/{id}', [TipoDocumentoController::class, 'update']);
Route::delete('/tipo_documento/{id}', [TipoDocumentoController::class, 'destroy']);

// Rutas para los permisos
Route::get('/permission', [PermissionController::class, 'index']);

// Rutas para el usuario
Route::get('/user', [UsuarioController::class, 'index']);
Route::delete('/user/{id}', [UsuarioController::class, 'destroy']);

//Rutas para Empleado Descuento
Route::get('/empleado_descuento', [EmpleadoDescuentoController::class, 'index']);
Route::get('/empleado_descuento/{id}', [EmpleadoDescuentoController::class, 'show']);
Route::post('/empleado_descuento', [EmpleadoDescuentoController::class, 'store']);
Route::put('/empleado_descuento/{id}', [EmpleadoDescuentoController::class, 'update']);
Route::patch('/empleado_descuento/{id}', [EmpleadoDescuentoController::class, 'update']);
Route::delete('/empleado_descuento/{id}', [EmpleadoDescuentoController::class, 'destroy']);

//Rutas para Empleado Descuento
Route::get('/empleado_ingreso', [EmpleadoIngresoController::class, 'index']);
Route::get('/empleado_ingreso/{id}', [EmpleadoIngresoController::class, 'show']);
Route::post('/empleado_ingreso', [EmpleadoIngresoController::class, 'store']);
Route::put('/empleado_ingreso/{id}', [EmpleadoIngresoController::class, 'update']);
Route::patch('/empleado_ingreso/{id}', [EmpleadoIngresoController::class, 'update']);
Route::delete('/empleado_ingreso/{id}', [EmpleadoIngresoController::class, 'destroy']);

//Rutas para Empleado Descuento
Route::get('/planilla', [PlanillaController::class, 'index']);
Route::get('/planilla/{id}', [PlanillaController::class, 'show']);
Route::post('/planilla', [PlanillaController::class, 'store']);
Route::put('/planilla/{id}', [PlanillaController::class, 'update']);
Route::patch('/planilla/{id}', [PlanillaController::class, 'update']);
Route::delete('/planilla/{id}', [PlanillaController::class, 'destroy']);
Route::get('/buscar_empleados', [PlanillaController::class, 'buscarEmpleadosPorRango']);
