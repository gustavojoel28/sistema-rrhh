<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    // 💡 CRÍTICO: Definir explícitamente el nombre de la tabla
    protected $table = 'planillas';

    // 💡 Campos que se pueden llenar masivamente
    protected $fillable = [
        'empleado_id',
        'mes_anio',
        'total_ingresos',
        'total_deducciones',
        'sueldo_neto',
        'estado'
    ];

    // Definición de la fecha para que Carbon pueda manejarla fácilmente
    protected $dates = [
        'mes_anio',
    ];

    // Relación para acceder a los datos del empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
