<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

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
}
