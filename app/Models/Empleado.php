<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'fecha_nacimiento',
        'direccion',
        'area_id',
        'cargo_id',
        'fecha_ingreso',
        'estado',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
