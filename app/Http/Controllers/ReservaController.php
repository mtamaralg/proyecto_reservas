<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'recurso', 'calendario.tramoHorario'])->get();
        return response()->json($reservas, 200);
    }

    public function store(Request $request)
    {
        // Hemos quitado fecha_inicio y fecha_fin. 
        // Ahora la reserva ocupa el "calendario" (turno) completo.
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'recurso_id' => 'required|exists:recursos,id',
            'calendario_id' => 'required|exists:calendarios,id'
        ]);

        $reserva = Reserva::create($request->request->all());
        return response()->json(['mensaje' => 'Reserva creada con éxito (Turno completo)', 'reserva' => $reserva], 201);
    }

    public function show(Reserva $reserva)
    {
        return response()->json($reserva->load(['usuario', 'recurso', 'calendario.tramoHorario']), 200);
    }

    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'usuario_id' => 'sometimes|required|exists:users,id',
            'recurso_id' => 'sometimes|required|exists:recursos,id',
            'calendario_id' => 'sometimes|required|exists:calendarios,id'
        ]);

        $reserva->update($request->all());
        return response()->json(['mensaje' => 'Reserva actualizada', 'reserva' => $reserva], 200);
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return response()->json(['mensaje' => 'Reserva eliminada'], 200);
    }
}