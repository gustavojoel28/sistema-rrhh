<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    // Si tu tabla se llama 'permisos' Laravel la detecta automáticamente,
    // pero dejamos la línea por claridad.
    protected $table = 'permisos';

    protected $fillable = [
        'empleado_id',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
