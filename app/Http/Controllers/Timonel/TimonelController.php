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
        return view('timonel.admin', compact('user', ('usuarios')));
    }
    public function cambiarRol(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->rol = $request->rol;
        $user->save();
        return back()->with('success', 'Rol actualizado correctamente.');
    }
}
