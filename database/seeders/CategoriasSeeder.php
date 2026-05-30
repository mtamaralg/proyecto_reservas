<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Equipos informáticos
        Categoria::create([
            'nombre' => 'Portátiles',
            'descripcion' => 'Ordenadores portátiles para préstamo a alumnos y profesores.'
        ]);

        // 2. Espacios físicos
        Categoria::create([
            'nombre' => 'Salas de Reuniones',
            'descripcion' => 'Salas insonorizadas equipadas con pizarra y pantalla para trabajos en grupo.'
        ]);

        // 3. Equipamiento Audiovisual
        Categoria::create([
            'nombre' => 'Proyectores',
            'descripcion' => 'Proyectores portátiles con conexión HDMI y VGA.'
        ]);

        // 4. Laboratorios
        Categoria::create([
            'nombre' => 'Impresoras 3D',
            'descripcion' => 'Equipos de impresión 3D (requiere aprobación del gestor).'
        ]);
        
        // 5. Material extra
        Categoria::create([
            'nombre' => 'Cámaras Fotográficas',
            'descripcion' => 'Cámaras réflex con trípode incluido para proyectos audiovisuales.'
        ]);
    }
}
