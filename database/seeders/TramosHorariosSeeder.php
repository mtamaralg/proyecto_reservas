<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TramoHorario;

class TramosHorariosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Turno de Mañana (Ej: Lunes, de 08:00 a 14:00)
        TramoHorario::create([
            'dia_semana' => 1, // 1 = Lunes
            'hora_inicio' => '08:00:00',
            'hora_fin' => '14:00:00'
        ]);

        // 2. Turno de Tarde (Ej: Lunes, de 15:00 a 21:00)
        TramoHorario::create([
            'dia_semana' => 1, // 1 = Lunes
            'hora_inicio' => '15:00:00',
            'hora_fin' => '21:00:00'
        ]);

        // 3. Turno de Mañana para el Martes
        TramoHorario::create([
            'dia_semana' => 2, // 2 = Martes
            'hora_inicio' => '08:00:00',
            'hora_fin' => '14:00:00'
        ]);
        
        // 4. Turno especial de fin de semana (Sábado por la mañana)
        TramoHorario::create([
            'dia_semana' => 6, // 6 = Sábado
            'hora_inicio' => '09:00:00',
            'hora_fin' => '13:30:00'
        ]);
    }
}