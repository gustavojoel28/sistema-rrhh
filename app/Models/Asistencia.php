<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $fillable = [
        'empleado_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'duracion',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
