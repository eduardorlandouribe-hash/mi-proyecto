<?php

namespace App\Http\Controllers\Timonel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Factura;
use App\Models\Materia;
use App\Models\Inscripcion;


class FacturaController extends Controller
{
    public function store()
    {
        $user = Auth::guard('timonel')->user();

        // Obtener materias inscritas
        $inscripciones = Inscripcion::where('estudiante_id', $user->id)
            ->with('materia')
            ->get();

        if ($inscripciones->isEmpty()) {
            return back()->with('error', 'No tienes materias inscritas.');
        }

        // Calcular total (valor por crédito: $150,000)
        $valorCredito = 350000;
        $total = $inscripciones->sum(fn($i) => $i->materia->creditos * $valorCredito);

        // Generar número de factura
        $numero = 'FAC-' . date('Y') . '-' . str_pad(
            Factura::count() + 1, 3, '0', STR_PAD_LEFT
        );

        // Crear la factura
        $factura = Factura::create([
            'numero'        => $numero,
            'estudiante_id' => $user->id,
            'total'         => $total,
            'estado'        => 'pendiente',
        ]);

        return redirect()->route('timonel.factura.show', $factura->id);
    }

    // Mostrar factura
    public function show($id)
    {
        $user = Auth::guard('timonel')->user();
        $factura = Factura::findOrFail($id);
        $inscripciones = Inscripcion::where('estudiante_id', $user->id)
            ->with('materia')
            ->get();

        return view('timonel.estudiante.factura', 
            compact('user', 'factura', 'inscripciones'));
    }
}
