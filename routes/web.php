<?php

use Illuminate\Support\Facades\Route;

// MODELOS
use App\Models\Area;
use App\Models\Cargo;
use App\Models\Empleado;

// CONTROLADORES
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PermisoController;

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $empleadosPorArea = Area::withCount('empleados')->get();

    $ultimosEmpleados = Empleado::with('area', 'cargo')
                                ->latest()
                                ->take(5)
                                ->get();

    return view('dashboard', [
        'areas' => Area::count(),
        'cargos' => Cargo::count(),
        'empleados' => Empleado::count(),
        'empleadosPorArea' => $empleadosPorArea,
        'ultimosEmpleados' => $ultimosEmpleados
    ]);

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN PRINCIPAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| CRUDS PRINCIPALES
|--------------------------------------------------------------------------
*/
Route::resource('areas', AreaController::class);
Route::resource('cargos', CargoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('permisos', PermisoController::class);

/*
|--------------------------------------------------------------------------
| ASISTENCIAS
|--------------------------------------------------------------------------
*/
Route::get('/asistencias', [AsistenciaController::class, 'index'])
    ->name('asistencias.index');

Route::post('/asistencias/entrada', [AsistenciaController::class, 'marcarEntrada'])
    ->name('asistencias.entrada');

Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalida'])
    ->name('asistencias.salida');

/*
|--------------------------------------------------------------------------
| PERMISOS (ALIAS Y ACCIONES EXTRA)
|--------------------------------------------------------------------------
*/
Route::get('/permisos/{empleado}/historial', [PermisoController::class, 'historial'])
    ->name('permisos.historial');

Route::get('/permisos/{id}/aprobar', [PermisoController::class, 'aprobar'])
    ->name('permisos.aprobar');

Route::get('/permisos/{id}/rechazar', [PermisoController::class, 'rechazar'])
    ->name('permisos.rechazar');
