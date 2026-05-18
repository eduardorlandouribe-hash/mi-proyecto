<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TimonelController extends Controller
{
    // Dashboard estudiante/profesor
    public function index()
    {
        $user = Auth::guard('timonel')->user();
        return view('timonel.index', compact('user'));
    }

    // Panel admin
    public function admin()
    {
        $user = Auth::guard('timonel')->user();

        // Solo admin puede entrar
        if ($user->rol !== 'admin') {
            return redirect()->route('timonel.index');
        }
        $usuarios = User::all();
        $materias = \App\Models\Materia::with('profesor')->get();

        return view('timonel.admin', compact('user', 'usuarios', 'materias'));
    }
    public function cambiarRol(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->rol = $request->rol;
        $user->save();
        return back()->with('success', 'Rol actualizado correctamente.');
    }
    // Dashboard del profesor
    public function profesorIndex()
    {
        $user = Auth::guard('timonel')->user();
        $materias = \App\Models\Materia::where('profesor_id', $user->id)
            ->with('inscripciones')
            ->get();
        return view('timonel.profesor.index', compact('user', 'materias'));
    }

    // Estudiantes de una materia
    public function profesorEstudiantes($id)
    {
        $user = Auth::guard('timonel')->user();
        $materia = \App\Models\Materia::where('id', $id)
            ->where('profesor_id', $user->id)
            ->firstOrFail();
        $estudiantes = \App\Models\Inscripcion::where('materia_id', $id)
            ->with(['estudiante', 'estudiante.facturas'])
            ->get();
        return view('timonel.profesor.estudiantes', compact('user', 'materia', 'estudiantes'));
    }
    public function financiero()
    {
        $user = Auth::guard('timonel')->user();
        $factura = \App\Models\Factura::where('estudiante_id', $user->id)
            ->latest()
            ->first();
        $inscripciones = \App\Models\Inscripcion::where('estudiante_id', $user->id)
            ->with('materia')
            ->get();
        return view('timonel.estudiante.financiero', compact('user', 'factura', 'inscripciones'));
    }
    public function perfil()
    {
        $user = Auth::guard('timonel')->user();
        return view('timonel.estudiante.perfil', compact('user'));
    }

    public function perfilUpdate(Request $request)
    {
        $user = Auth::guard('timonel')->user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            if (!Hash::check($request->password_actual, $user->password)) {
                return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
            }
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('success', 'Cambios guardados correctamente.');
    }
    public function notas()
    {
        $user = Auth::guard('timonel')->user();
        $notas = \App\Models\Nota::where('estudiante_id', $user->id)
            ->with('materia')
            ->get();
        return view('timonel.estudiante.notas', compact('user', 'notas'));
    }
}
