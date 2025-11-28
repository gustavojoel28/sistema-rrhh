<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema RRHH - Panel</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>

        /* ===== MODO OSCURO ===== */
        body.dark {
            background: #121212 !important;
            color: white !important;
        }

        .dark .card {
            background: #1e1e1e !important;
            color: white !important;
        }

        .dark .topbar {
            background: #1e1e1e !important;
            color: white !important;
        }

        .dark .sidebar {
            background: #000 !important;
        }

        .dark .sidebar a {
            color: #dcdcdc !important;
        }

        .dark .sidebar a:hover {
            background: #242424 !important;
        }

        /* ===== ESTILO GENERAL ===== */
        body {
            background: #f5f6fa;
            transition: all 0.3s ease-in-out;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1b1b2f;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
        }

        .sidebar h4 {
            color: white;
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #c5c8d4;
            text-decoration: none;
            font-size: 16px;
            transition: all .2s;
        }

        .sidebar a:hover {
            background: #23233a;
            color: white;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .content {
            margin-left: 260px;
            padding: 25px;
            transition: all .3s;
        }

        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4><i class="bi bi-people-fill"></i> RRHH</h4>

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('areas.index') }}">
            <i class="bi bi-folder"></i> Áreas
        </a>

        <a href="{{ route('cargos.index') }}">
            <i class="bi bi-briefcase"></i> Cargos
        </a>

        <a href="{{ route('empleados.index') }}">
            <i class="bi bi-person-badge"></i> Empleados
        </a>

        <hr class="dropdown-divider my-2" style="background: rgba(255, 255, 255, 0.2);">

        <a href="{{ route('asistencias.index') }}">
            <i class="bi bi-calendar-check"></i> Asistencias
        </a>

        <a href="{{ route('permisos.index') }}">
            <i class="bi bi-file-earmark-text"></i> Permisos
        </a>

        <a href="{{ route('planillas.index') }}">
            <i class="bi bi-currency-dollar"></i> Planillas
        </a>

        <a href="{{ route('conceptos.index') }}">
            <i class="bi bi-gear"></i> Configuración Planilla
        </a>
  </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="topbar">
            <h4 class="m-0"><i class="bi bi-grid"></i> Panel Administrativo</h4>

            <!-- BOTÓN MODO OSCURO / CLARO -->
            <button id="toggleDarkMode" class="btn btn-dark">
                <i class="bi bi-moon-stars"></i>
            </button>
        </div>

        @yield('content')

    </div>


    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SCRIPT MODO OSCURO -->
    <script>
        const toggle = document.getElementById('toggleDarkMode');

        toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');

            // Cambiar icono
            if (document.body.classList.contains('dark')) {
                toggle.classList.replace('btn-dark', 'btn-light');
                toggle.innerHTML = '<i class="bi bi-brightness-high"></i>';
            } else {
                toggle.classList.replace('btn-light', 'btn-dark');
                toggle.innerHTML = '<i class="bi bi-moon-stars"></i>';
            }
        });
    </script>

</body>
</html>
