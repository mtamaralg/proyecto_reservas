<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;

class ReservasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reserva del Estudiante: MacBook Pro en el Turno 1 (15 de Octubre por la mañana)
        Reserva::create([
            'usuario_id' => 2, 
            'recurso_id' => 1, 
            'calendario_id' => 1, 
        ]);

        // 2. Reserva del Profesor: Sala Ada Lovelace en el Turno 2 (16 de Octubre por la tarde)
        Reserva::create([
            'usuario_id' => 3, 
            'recurso_id' => 3, 
            'calendario_id' => 2, 
        ]);

        // 3. Reserva del Estudiante: Cámara Fotográfica en el Turno 3 (1 de Noviembre)
        Reserva::create([
            'usuario_id' => 2, 
            'recurso_id' => 5, 
            'calendario_id' => 3, 
        ]);
    }
}