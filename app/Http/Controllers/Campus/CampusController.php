<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Campus\MateriaDetalleController;

class CampusController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'profesor') {
            $materias = \App\Models\Materia::where('profesor_id', $user->id)
                ->with('profesor')
                ->get();
        } else {
            $materias = \App\Models\Materia::whereHas('inscripciones', function ($q) use ($user) {
                $q->where('estudiante_id', $user->id);
            })->with('profesor')->get();
        }

        return view('campus.index', compact('materias'));
    }
    public function materia($id)
    {
        return app(MateriaDetalleController::class)->show($id);
    }
}
