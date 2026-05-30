<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importamos a todos nuestros "camareros" (Controladores)
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TramoHorarioController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ReservaController;

// ---------------------------------------------------
// 1. RUTAS PÚBLICAS (Cualquiera puede entrar)
// ---------------------------------------------------
// Route::post('/registro', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);


// ---------------------------------------------------
// 2. RUTAS PRIVADAS (Solo con el Token VIP de Sanctum)
// ---------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para que Vue pregunte "¿Quién soy?"
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // ¡La magia de Laravel! 
    // Con 'apiResource', Laravel crea automáticamente las 5 rutas (GET, POST, PUT, DELETE) 
    // para cada uno de nuestros controladores sin tener que escribirlas a mano una a una.
    
    
    
});
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('recursos', RecursoController::class);
    Route::apiResource('tramos-horarios', TramoHorarioController::class);
    Route::apiResource('calendarios', CalendarioController::class);
    Route::apiResource('reservas', ReservaController::class);
    