<?php

namespace App\Http\Controllers;

use App\Models\TramoHorario;
use Illuminate\Http\Request;

class TramoHorarioController extends Controller
{
    /**
     * Muestra una lista de todos los tramos horarios.
     * Método: GET
     */
    public function index()
    {
        // Al igual que con las categorías, usamos all() porque es un catálogo simple.
        // Nos trae todos los tramos horarios disponibles en la base de datos sin relaciones extra.
        $tramos = TramoHorario::all();
        
        // Devolvemos el array de tramos en formato JSON con estado 200 (OK).
        return response()->json($tramos, 200);
    }

    /**
     * Crea y guarda un nuevo tramo horario.
     * Método: POST
     */
    public function store(Request $request)
    {
        // Validamos estrictamente el formato y la lógica de los tiempos.
        $request->validate([
            // 'dia_semana' debe ser un número del 1 al 7 (usualmente 1=Lunes, 7=Domingo).
            'dia_semana' => 'required|integer|between:1,7',
            
            // 'hora_inicio' es requerida y DEBE coincidir exactamente con el formato Hora:Minuto:Segundo (ej. "08:30:00").
            'hora_inicio' => 'required|date_format:H:i:s',
            
            // 'hora_fin' también requiere el mismo formato exacto.
            // Además, usamos 'after:hora_inicio' para garantizar que el tramo tenga sentido 
            // (no puedes terminar un turno antes de empezarlo).
            'hora_fin' => 'required|date_format:H:i:s|after:hora_inicio'
        ]);

        // Si los formatos y la lógica temporal son correctos, creamos el tramo.
        $tramo = TramoHorario::create($request->all());
        
        // Retornamos el objeto recién creado con un mensaje y código 201 (Created).
        return response()->json(['mensaje' => 'Tramo creado', 'tramo' => $tramo], 201);
    }

    /**
     * Muestra la información de un solo tramo horario.
     * Método: GET
     * @param TramoHorario $tramoHorario (Inyección automática del modelo)
     */
    public function show(TramoHorario $tramoHorario)
    {
        // Laravel ya buscó el tramo por su ID. Lo devolvemos directamente en formato JSON.
        return response()->json($tramoHorario, 200);
    }

    /**
     * Actualiza la información de un tramo horario existente.
     * Método: PUT / PATCH
     */
    public function update(Request $request, TramoHorario $tramoHorario)
    {
        // Validamos los datos a actualizar usando 'sometimes' para permitir actualizaciones parciales.
        $request->validate([
            'dia_semana' => 'sometimes|required|integer|between:1,7',
            'hora_inicio' => 'sometimes|required|date_format:H:i:s',
            
            // Incluso si solo se actualiza la hora de fin, Laravel verificará que siga siendo 
            // posterior a la hora de inicio que ya está registrada (o a la nueva si se envían ambas).
            'hora_fin' => 'sometimes|required|date_format:H:i:s|after:hora_inicio'
        ]);

        // Aplicamos los cambios al modelo en la base de datos.
        $tramoHorario->update($request->all());
        
        // Devolvemos el mensaje de éxito y el tramo actualizado.
        return response()->json(['mensaje' => 'Tramo actualizado', 'tramo' => $tramoHorario], 200);
    }

    /**
     * Elimina un tramo horario específico.
     * Método: DELETE
     */
    public function destroy(TramoHorario $tramoHorario)
    {
        // Borramos físicamente el registro.
        $tramoHorario->delete();
        
        // Devolvemos la confirmación de la eliminación.
        return response()->json(['mensaje' => 'Tramo eliminado'], 200);
    }
}