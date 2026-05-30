<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tu usuario Administrador (el que ya teníamos)
        User::create([
            'name' => 'Marina Admin',
            'email' => 'admin@reservas.com',
            'password' => Hash::make('12345678'),
            'rol' => 'admin'
        ]);

        // 2. Un usuario normal (para probar las reservas regulares)
        User::create([
            'name' => 'Estudiante Prueba',
            'email' => 'estudiante@reservas.com',
            'password' => Hash::make('12345678'), // Misma contraseña para que no se te olvide
            'rol' => 'usuario'
        ]);
        
        // 3. Un usuario gestor (para el futuro, por si quieres dar permisos intermedios)
        User::create([
            'name' => 'Profe Gestor',
            'email' => 'gestor@reservas.com',
            'password' => Hash::make('12345678'),
            'rol' => 'gestor'
        ]);
    }
}
