<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Muestra una lista de todas las categorías.
     * Método: GET
     */
    public function index()
    {
        // Usamos el método all() de Eloquent para traer todos los registros de la tabla categorías.
        // Como no hay relaciones declaradas aquí, es una consulta directa y sencilla.
        $categorias = Categoria::all();
        
        // Devolvemos la colección de categorías en formato JSON con un código 200 (OK).
        return response()->json($categorias, 200);
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     * Método: POST
     */
    public function store(Request $request)
    {
        // Validamos los datos enviados por el usuario en el cuerpo de la petición.
        $request->validate([
            // 'nombre' es obligatorio, debe ser una cadena de texto y no exceder los 255 caracteres (límite estándar de base de datos).
            'nombre' => 'required|string|max:255',
            // 'descripcion' es opcional (nullable). Si se envía, debe ser texto, pero si no se envía o viene nulo, la validación pasa.
            'descripcion' => 'nullable|string'
        ]);

        // Se crea el registro en la base de datos usando los datos validados del request.
        $categoria = Categoria::create($request->all());
        
        // Respondemos con un mensaje y el objeto creado. El código 201 indica "Created" (Creado con éxito).
        return response()->json(['mensaje' => 'Categoría creada', 'categoria' => $categoria], 201);
    }

    /**
     * Muestra la información de una sola categoría.
     * Método: GET
     * @param Categoria $categoria (Inyección de dependencias / Route Model Binding)
     */
    public function show(Categoria $categoria)
    {
        // Laravel ya buscó la categoría en la base de datos por nosotros gracias al tipo de dato (Categoria $categoria).
        // Simplemente la devolvemos en formato JSON.
        return response()->json($categoria, 200);
    }

    /**
     * Actualiza la información de una categoría existente.
     * Método: PUT / PATCH
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validamos los datos a actualizar.
        $request->validate([
            // 'sometimes' indica que el 'nombre' solo se validará si viene incluido en el request.
            // Esto permite actualizar solo la descripción sin necesidad de volver a enviar el nombre.
            'nombre' => 'sometimes|required|string|max:255',
            // La descripción sigue siendo opcional.
            'descripcion' => 'nullable|string'
        ]);

        // Actualizamos el modelo con los nuevos datos.
        $categoria->update($request->all());
        
        // Devolvemos la confirmación y los datos actualizados.
        return response()->json(['mensaje' => 'Categoría actualizada', 'categoria' => $categoria], 200);
    }

    /**
     * Elimina una categoría de la base de datos.
     * Método: DELETE
     */
    public function destroy(Categoria $categoria)
    {
        // Borramos el registro de la tabla.
        $categoria->delete();
        
        // Devolvemos un mensaje de éxito indicando que el proceso finalizó correctamente.
        return response()->json(['mensaje' => 'Categoría eliminada'], 200);
    }
}