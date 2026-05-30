<?php

namespace App\Http\Controllers;

use App\Models\Calendario;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        $calendarios = Calendario::with('tramoHorario')->get();
        return response()->json($calendarios, 200);
    }

    public function store(Request $request)
    {
        // Actualizado para validar 'fecha' en lugar de dia, mes y año sueltos.
        $request->validate([
            'fecha' => 'required|date',
            'tramos_horarios_id' => 'required|exists:tramos_horarios,id'
        ]);

        $calendario = Calendario::create($request->all());
        return response()->json(['mensaje' => 'Día de calendario creado', 'calendario' => $calendario], 201);
    }

    public function show(Calendario $calendario)
    {
        return response()->json($calendario->load('tramoHorario'), 200);
    }

    public function update(Request $request, Calendario $calendario)
    {
        $request->validate([
            'fecha' => 'sometimes|required|date',
            'tramos_horarios_id' => 'sometimes|required|exists:tramos_horarios,id'
        ]);

        $calendario->update($request->all());
        return response()->json(['mensaje' => 'Calendario actualizado', 'calendario' => $calendario], 200);
    }

    public function destroy(Calendario $calendario)
    {
        $calendario->delete();
        return response()->json(['mensaje' => 'Día de calendario eliminado'], 200);
    }
}
