<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'nombre',
        'area_id',
        'descripcion'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
