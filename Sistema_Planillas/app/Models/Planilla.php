<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'planilla';

    public $timestamps = false;

    // Indicar que la clave primaria no es 'id'
    protected $primaryKey = 'codigo_planilla';
    protected $fillable = [
        'fecha_inicio',
        'fecha_fin'
    ];
}
