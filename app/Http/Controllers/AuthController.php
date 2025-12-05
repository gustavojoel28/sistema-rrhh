<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        // Si el usuario ya está autenticado, lo redirigimos al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Procesa el formulario de login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 💡 Lógica de Roles (Spatie)
            $user = Auth::user();
            if ($user->hasRole('Administrador RRHH')) {
                return redirect()->route('dashboard');
            }

            // Si es un Empleado normal, redirigirlo a un dashboard específico de empleado
            // Por ahora, redirigimos a dashboard, pero esto se refinará después.
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
