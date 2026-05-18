<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'materia_id'   => 'required|exists:materias,id',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'fecha_limite' => 'required|date',
        ]);

        Tarea::create([
            'materia_id'   => $request->materia_id,
            'profesor_id'  => Auth::id(),
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
        ]);

        return back()->with('success', 'Tarea creada correctamente.');
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();
        return back()->with('success', 'Tarea eliminada.');
    }
}
