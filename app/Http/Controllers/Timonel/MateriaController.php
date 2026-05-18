<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class MateriaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('timonel')->user();
        $materias = Materia::with('profesor')->get();
        $profesores = User::where('rol', 'profesor')->get();
        return view('timonel.admin.materias', compact('user', 'materias', 'profesores'));
    }

    // Crear nueva materia
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'codigo'      => 'required|string|unique:materias,codigo',
            'creditos'    => 'required|integer|min:1|max:10',
            'horario'     => 'required|string',
            'salon'       => 'required|string',
            'profesor_id' => 'nullable|exists:users,id',
        ]);

        Materia::create($request->all());

        return redirect()->route('timonel.materias.index')
            ->with('success', 'Materia creada correctamente.');
    }

    // Actualizar materia
    public function update(Request $request, $id)
    {
        $materia = Materia::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:255',
            'codigo'      => 'required|string|unique:materias,codigo,' . $id,
            'creditos'    => 'required|integer|min:1|max:10',
            'horario'     => 'required|string',
            'salon'       => 'required|string',
            'profesor_id' => 'nullable|exists:users,id',
        ]);

        $materia->update($request->all());

        return redirect()->route('timonel.materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    // Eliminar materia
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('timonel.materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}
