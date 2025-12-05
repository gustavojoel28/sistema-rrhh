<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema RRHH Vice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f5f6fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { max-width: 450px; padding: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: white; }
        .logo { font-size: 2rem; color: #0d6efd; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center logo"><i class="bi bi-people-fill"></i> Sistema RRHH</h3>
    <h4 class="text-center mb-4">Iniciar Sesión</h4>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Acceder</button>
    </form>
</div>

</body>
</html>
