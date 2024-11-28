<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Persona;
class personaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persona::Insert([
            [
                'nombres'   => 'Administrador',   
                'apellidos' => 'Sistema',
                'dni' => 'sin dni',
                'direccion' => 'no disponible',
                'telefono' => 'no disponible',
                'area_id'  => '1',
                'user_id'  => '1'
            ],
            
        ]);
    }
}
