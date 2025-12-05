<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User; // Asegúrate de que tu modelo User esté en App\Models\User
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Roles (Si no existen)
        $rolAdmin = Role::firstOrCreate(['name' => 'Administrador RRHH']);
        $rolEmpleado = Role::firstOrCreate(['name' => 'Empleado']);

        // 2. Crear un Usuario de Prueba para el Administrador (Si no existe)
        $adminUser = User::firstOrCreate(
            [
                'email' => 'admin@vice.gob.pe' // Correo institucional de prueba
            ],
            [
                'name' => 'Admin RRHH',
                'password' => Hash::make('password'), // Contraseña simple: 'password'
                'email_verified_at' => now(),
                'empleado_id' => null // Por ahora, null, pero deberías vincularlo a un Empleado real
            ]
        );

        // 3. Asignar el Rol al Usuario
        // Solo asignamos si el usuario fue creado o si aún no tiene roles
        if ($adminUser->wasRecentlyCreated || $adminUser->roles->isEmpty()) {
            $adminUser->assignRole($rolAdmin);

            // Opcional: Crear un usuario de empleado de prueba
            $empleadoUser = User::firstOrCreate(
                [
                    'email' => 'empleado@vice.gob.pe'
                ],
                [
                    'name' => 'Usuario Empleado',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'empleado_id' => null
                ]
            );
            $empleadoUser->assignRole($rolEmpleado);
        }
    }
}
