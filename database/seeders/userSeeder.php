<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'administrador',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        
        //$user = User::find(1);
        $rol = Role::create(['name'=>'Administrador']);
        $permiso = Permission::pluck('id','id')->all();
        $rol->syncPermissions($permiso);
        $user->assignRole('Administrador');
    }
}
