<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recurso;

class RecursosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Recursos para la categoría "Portátiles" (categoria_id = 1)
        Recurso::create([
            'categoria_id' => 1,
            'nombre' => 'MacBook Pro M2',
            'descripcion' => 'Portátil Apple MacBook Pro con chip M2 y 16GB RAM. Ideal para diseño.'
        ]);
        Recurso::create([
            'categoria_id' => 1,
            'nombre' => 'Dell XPS 15',
            'descripcion' => 'Portátil Dell con Windows 11, Intel Core i7 y gráfica dedicada.'
        ]);

        // 2. Recursos para la categoría "Salas de Reuniones" (categoria_id = 2)
        Recurso::create([
            'categoria_id' => 2,
            'nombre' => 'Sala Ada Lovelace',
            'descripcion' => 'Sala con capacidad para 6 personas. Incluye pizarra digital.'
        ]);
        Recurso::create([
            'categoria_id' => 2,
            'nombre' => 'Sala Alan Turing',
            'descripcion' => 'Sala para 4 personas, muy silenciosa y aislada.'
        ]);

        // 3. Recursos para la categoría "Proyectores" (categoria_id = 3)
        Recurso::create([
            'categoria_id' => 3,
            'nombre' => 'Proyector Epson EB-U05',
            'descripcion' => 'Proyector Full HD 1080p, 3400 lúmenes.'
        ]);

        // 4. Recursos para la categoría "Impresoras 3D" (categoria_id = 4)
        Recurso::create([
            'categoria_id' => 4,
            'nombre' => 'Prusa i3 MK3S+',
            'descripcion' => 'Impresora 3D de filamento (PLA/PETG). Incluye bobina blanca.'
        ]);

        // 5. Recursos para la categoría "Cámaras Fotográficas" (categoria_id = 5)
        Recurso::create([
            'categoria_id' => 5,
            'nombre' => 'Canon EOS 90D',
            'descripcion' => 'Cámara réflex de 32.5 MP con objetivo 18-55mm y bolsa de transporte.'
        ]);
    }
}