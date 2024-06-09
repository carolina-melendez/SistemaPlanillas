<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoDescuento extends Model
{
    use HasFactory;

    protected $table = 'empleado_descuentos';
    protected $primaryKey = 'codigo_descuento';

    protected $fillable = [
        'codigo_empleado',
        'tipo_descuento_id',
        'monto',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado');
    }

    public function tipoDescuento()
    {
        return $this->belongsTo(TipoDescuento::class, 'id_descuento');
    }
}
