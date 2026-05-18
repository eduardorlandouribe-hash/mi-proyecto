<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;


class MaterialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'nombre'     => 'required|string|max:255',
            'tipo'       => 'required|in:pdf,link,imagen',
            'url'        => 'required|string',
        ]);

        Material::create([
            'materia_id'  => $request->materia_id,
            'profesor_id' => Auth::id(),
            'nombre'      => $request->nombre,
            'tipo'        => $request->tipo,
            'url'         => $request->url,
        ]);

        return back()->with('success', 'Material subido correctamente.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return back()->with('success', 'Material eliminado.');
    }
}
