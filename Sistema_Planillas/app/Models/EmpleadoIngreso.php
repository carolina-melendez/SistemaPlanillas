<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoIngreso extends Model
{
    use HasFactory;

    protected $table = 'empleado_ingresos';
    protected $primaryKey = 'codigo_ingreso';

    protected $fillable = [
        'codigo_empleado',
        'tipo_ingreso_id',
        'monto',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado');
    }

    public function tipoIngreso()
    {
        return $this->belongsTo(TipoIngreso::class, 'id_ingreso');
    }
}
