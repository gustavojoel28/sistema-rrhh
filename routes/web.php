<?php

use Illuminate\Support\Facades\Route;

// MODELOS (Mantenemos por si el dashboard los usa)
use App\Models\Area;
use App\Models\Cargo;
use App\Models\Empleado;

// CONTROLADORES
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ConceptoPlanillaController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AuthController; // 💡 Nuevo controlador de autenticación

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login - HU06)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 💡 LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 💡 DASHBOARD (Página principal protegida)
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

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
    | CRUDS PRINCIPALES (Solo Administrador RRHH)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Administrador RRHH')->group(function () {

        // MÓDULOS BASE
        Route::resource('areas', AreaController::class);
        Route::resource('cargos', CargoController::class);
        Route::resource('empleados', EmpleadoController::class);

        // ASISTENCIAS (CRUD, pero la protección fuerte está en los Constructores)
        Route::get('/asistencias', [AsistenciaController::class, 'index'])
            ->name('asistencias.index');
        Route::post('/asistencias/entrada', [AsistenciaController::class, 'marcarEntrada'])
            ->name('asistencias.entrada');
        Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalida'])
            ->name('asistencias.salida');

        // PLANILLAS Y CONCEPTOS
        Route::resource('conceptos', ConceptoPlanillaController::class);
        Route::get('/planillas/generar', [PlanillaController::class, 'create'])->name('planillas.create');
        Route::post('/planillas/generar', [PlanillaController::class, 'generarPlanilla'])->name('planillas.generar');
        Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
        Route::get('/planillas/{mes_anio}', [PlanillaController::class, 'show'])->name('planillas.show');

        // REPORTES
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/pdf', [ReporteController::class, 'exportarPDF'])->name('reportes.pdf');

        // PERMISOS (Flujo de Aprobación/Rechazo)
        Route::post('/permisos/{permiso}/aprobar', [PermisoController::class, 'aprobar'])->name('permisos.aprobar');
        Route::post('/permisos/{permiso}/rechazar', [PermisoController::class, 'rechazar'])->name('permisos.rechazar');
    });


    /*
    |--------------------------------------------------------------------------
    | RUTAS COMPARTIDAS (Empleado y Admin)
    |--------------------------------------------------------------------------
    */
    // Los empleados y administradores necesitan ver el listado de permisos (aunque el empleado solo vea los suyos)
    Route::resource('permisos', PermisoController::class)->except(['aprobar', 'rechazar']);

    Route::get('/permisos/{empleado}/historial', [PermisoController::class, 'historial'])
        ->name('permisos.historial');
});
