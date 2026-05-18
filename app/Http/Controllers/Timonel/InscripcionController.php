<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function index()
    {
        $user = Auth::guard('timonel')->user();
        $materias = Materia::with('profesor')->get();
        $inscritas = Inscripcion::where('estudiante_id', $user->id)
            ->pluck('materia_id')
            ->toArray();

        return view('timonel.estudiante.inscripcion', 
            compact('user', 'materias', 'inscritas'));
    }

    // Inscribirse en una materia
    public function store(Request $request)
    {
        $user = Auth::guard('timonel')->user();

        $request->validate([
            'materia_id' => 'required|exists:materias,id',
        ]);

        // Verificar que no esté ya inscrito
        $existe = Inscripcion::where('estudiante_id', $user->id)
            ->where('materia_id', $request->materia_id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya estás inscrito en esta materia.');
        }

        Inscripcion::create([
            'estudiante_id' => $user->id,
            'materia_id'    => $request->materia_id,
        ]);

        return back()->with('success', 'Inscripción exitosa.');
    }

    // Cancelar inscripción
    public function destroy($id)
    {
        $user = Auth::guard('timonel')->user();

        $inscripcion = Inscripcion::where('estudiante_id', $user->id)
            ->where('materia_id', $id)
            ->firstOrFail();

        $inscripcion->delete();

        return back()->with('success', 'Inscripción cancelada.');
    }
}
