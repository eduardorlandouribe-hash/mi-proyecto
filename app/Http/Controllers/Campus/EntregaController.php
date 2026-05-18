<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrega;
use App\Models\Tarea;

class EntregaController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
            'tarea_id'   => 'required|exists:tareas,id',
            'comentario' => 'nullable|string',
        ]);

        $existe = Entrega::where('tarea_id', $request->tarea_id)
            ->where('estudiante_id', Auth::id())
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya entregaste esta tarea.');
        }

        Entrega::create([
            'tarea_id'     => $request->tarea_id,
            'estudiante_id'=> Auth::id(),
            'comentario'   => $request->comentario,
            'estado'       => 'entregada',
        ]);

        return back()->with('success', 'Tarea entregada correctamente.');
    }

    public function entregas($tareaId)
    {
        $user = Auth::user();
        $tarea = Tarea::with(['entregas.estudiante'])->findOrFail($tareaId);
        return view('campus.entregas', compact('user', 'tarea'));
    }
}
