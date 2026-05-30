<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    /**
     * Muestra una lista de todos los recursos.
     * Método: GET
     */
    public function index()
    {
        // Traemos todos los recursos de la base de datos.
        // Usamos 'with('categoria')' para incluir la información de la categoría a la que pertenece cada recurso.
        // Esto previene el problema de N+1 consultas (Eager Loading), optimizando el rendimiento.
        $recursos = Recurso::with('categoria')->get();
        
        // Retornamos la respuesta en formato JSON con un código de estado 200 (OK).
        return response()->json($recursos, 200);
    }

    /**
     * Guarda un nuevo recurso en la base de datos.
     * Método: POST
     */
    public function store(Request $request)
    {
        // Validamos la información que viene en el cuerpo de la petición HTTP.
        $request->validate([
            // 'categoria_id' es obligatorio y DEBE existir en la columna 'id' de la tabla 'categorias'.
            // Esto asegura la integridad referencial (no puedes asignar un recurso a una categoría fantasma).
            'categoria_id' => 'required|exists:categorias,id',
            // 'nombre' es obligatorio, debe ser texto y máximo de 255 caracteres.
            'nombre' => 'required|string|max:255',
            // 'descripcion' es opcional. Si se envía, debe ser una cadena de texto.
            'descripcion' => 'nullable|string'
        ]);

        // Si la validación es correcta, creamos el recurso de forma masiva con los datos recibidos.
        $recurso = Recurso::create($request->all());
        
        // Devolvemos un mensaje de éxito junto con los datos del nuevo recurso y un código 201 (Created).
        return response()->json(['mensaje' => 'Recurso creado', 'recurso' => $recurso], 201);
    }

    /**
     * Muestra la información de un solo recurso específico.
     * Método: GET
     * @param Recurso $recurso (Laravel inyecta automáticamente el modelo basado en la URL)
     */
    public function show(Recurso $recurso)
    {
        // Como ya tenemos el modelo $recurso instanciado por Laravel, usamos 'load' en lugar de 'with'.
        // 'load()' anexa dinámicamente los datos de la relación 'categoria' a este registro en particular.
        return response()->json($recurso->load('categoria'), 200);
    }

    /**
     * Actualiza la información de un recurso existente.
     * Método: PUT / PATCH
     */
    public function update(Request $request, Recurso $recurso)
    {
        // Validamos los datos entrantes.
        $request->validate([
            // Usamos 'sometimes' para indicar que estas validaciones SOLO se aplican 
            // si el campo correspondiente viene en la petición. Ideal para actualizar campos sueltos.
            'categoria_id' => 'sometimes|required|exists:categorias,id',
            'nombre' => 'sometimes|required|string|max:255',
            // Sigue siendo opcional.
            'descripcion' => 'nullable|string'
        ]);

        // Guardamos los cambios en la base de datos.
        $recurso->update($request->all());
        
        // Retornamos un mensaje de éxito y el recurso ya actualizado con estado 200 (OK).
        return response()->json(['mensaje' => 'Recurso actualizado', 'recurso' => $recurso], 200);
    }

    /**
     * Elimina un recurso de la base de datos.
     * Método: DELETE
     */
    public function destroy(Recurso $recurso)
    {
        // Eliminamos físicamente el registro de la tabla (a menos que uses SoftDeletes en tu modelo).
        $recurso->delete();
        
        // Confirmamos que la acción se realizó con éxito mediante un JSON y estado 200.
        return response()->json(['mensaje' => 'Recurso eliminado'], 200);
    }
}