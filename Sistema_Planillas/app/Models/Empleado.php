<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $primaryKey = 'codigo_empleado';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'tercer_nombre',
        'apellido_paterno',
        'apellido_materno',
        'apellido_de_casada',
        'numero_documento',
        'tipo_documento_id',
        'fecha_nacimiento',
        'numero_identificacion_tributaria',
        'codigo_isss',
        'codigo_nup',
        'id_profesion',
        'id_estado_civil',
        'direccion',
        'pais_direccion_id',
        'departamento_id',
        'municipio_id',
        'codigo_cargo',
        'codigo_unidad',
        'codigo_jefe',
        'correo_institucional',
        'salario',
        'status',
        'sexo',
        'fecha_contratacion',
        'fecha_despido',
        'correo_personal',
        'telefono_contacto'
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'codigo');
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class, 'id_profesion', 'id_profesion');
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'id_estado_civil', 'id_estado_civil');
    }

    public function paisDireccion()
    {
        return $this->belongsTo(Pais::class, 'pais_direccion_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'codigo_cargo', 'codigo_cargo');
    }

    public function unidadOrganizativa()
    {
        return $this->belongsTo(UnidadOrganizativa::class, 'codigo_unidad', 'codigo_unidad');
    }

    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'codigo_jefe', 'codigo_empleado');
    }
}
