<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoPlanilla extends Model
{
    protected $table = 'conceptos_planillas';
    protected $fillable = [
        'nombre',
        'tipo',
        'calculo',
        'valor'
    ];
}
