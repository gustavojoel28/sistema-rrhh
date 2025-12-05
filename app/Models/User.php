<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Importar el Trait de Spatie

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Usar el Trait y notificaciones

    /**
     * Los atributos que son asignables en masa.
     * Incluye empleado_id para la vinculación con el personal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'empleado_id', // 💡 CRÍTICO: Añadido para permitir asignar el ID del empleado
    ];

    /**
     * Los atributos que deben ser ocultados para las serializaciones.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relación: Un Usuario pertenece a un Empleado (1:1)
     * Esto vincula la cuenta de login con la ficha de RRHH.
     */
    public function empleado()
    {
        // 💡 CLAVE: Usa la columna 'empleado_id' que acabamos de agregar en la migración
        return $this->belongsTo(Empleado::class);
    }
}
