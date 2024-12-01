<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            //middleware de areas
            'ver-area',
            'crear-area',
            'editar-area',
            'eliminar-area',

            ///mifelware autores
            'ver-autor',
            'crear-autor',
            'editar-autor',
            'aliminar-autor',

            //catalogo
            'ver-catalogo',

            //categorias
            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'eliminar-categoria',

            //copia libros
            'crear-copia',
            'eliminar-copia',

            //devoluciones
            'crear-devolucion',

            //libro
            'ver-libro',
            'crear-libro',
            'editar-libro',
            'eliminar-libro',

            //penalizaciones
            'editar-penalizacion',

            //persona
            'ver-persona',
            'crear-persona',
            'editar-persona',
            'eliminar-persona',

            //prestamo
            'ver-prestamo',
            'ver-mis-prestamos',
            'crear-prestamo',
            'eliminar-prestamo',

            //reserva
            'ver-reserva',
            'ver-mis-reservas',
            'crear-reserva',
            'eliminar-reserva',

            //roles
            'ver-roles',
            'crear-roles',
            'editar-roles',
            'eliminar-roles',
        ];
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
