<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Materia;
use App\Models\Entrega;

class MateriaDetalleController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        $materia = Materia::with(['profesor', 'materiales', 'tareas'])
            ->findOrFail($id);

        // Obtener entregas del estudiante para esta materia
        $entregas = [];
        if ($user->rol === 'estudiante') {
            $entregas = Entrega::whereHas('tarea', function($q) use ($id) {
                $q->where('materia_id', $id);
            })->where('estudiante_id', $user->id)
              ->pluck('estado', 'tarea_id')
              ->toArray();
        }

        return view('campus.materia', compact('user', 'materia', 'entregas'));
    }
}
