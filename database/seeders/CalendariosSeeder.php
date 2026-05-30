<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calendario;

class CalendariosSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos un día en el calendario (Ej: 15 de Octubre de 2026, turno de mañana)
        Calendario::create([
            'fecha' => '2026-10-15',
            'tramos_horarios_id' => 1 
        ]);

        // Creamos el mismo día, pero en el turno de tarde (tramos_horarios_id 2)
        Calendario::create([
            'fecha' => '2026-10-15',
            'tramos_horarios_id' => 2 
        ]);
        
        // Creamos otro día distinto (Ej: 16 de Octubre de 2026, turno de mañana)
        Calendario::create([
            'fecha' => '2026-10-16',
            'tramos_horarios_id' => 1 
        ]);
    }
}