<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampusController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $materias = collect(); // Por ahora vacío, luego conectamos con BD

        return view('campus.index', compact('user', 'materias'));
    }
}
