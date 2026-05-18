<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class TimonelAuthController extends Controller
{
    // Mostrar login
    public function showLogin()
    {
        return view('timonel.login');
    }

    // verifica que este bien el login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('timonel')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $rol = Auth::guard('timonel')->user()->rol;
            
            return match($rol) {
                'admin' => redirect()->route('timonel.admin'),
                default => redirect()->route('timonel.index'),
                'profesor' => redirect()->route('timonel.profesor.index')
            };
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::guard('timonel')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('pagina_web');
    }
}
