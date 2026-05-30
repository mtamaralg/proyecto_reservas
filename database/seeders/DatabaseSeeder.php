<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Aquí llamamos a los seeders que hemos creado
        $this->call([
            UsuariosSeeder::class,
            CategoriasSeeder::class,
            RecursosSeeder::class,
            TramosHorariosSeeder::class,
            CalendariosSeeder::class,
            ReservasSeeder::class,
        ]);
    }
}
