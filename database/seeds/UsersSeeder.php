<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();

        $superadminRole = Role::create(['name' => 'Super-Administrador']);
        $adminRole = Role::create(['name' => 'Administrador']);
        $meseroRole = Role::create(['name' => 'Mesero']);
        $cobradorRole = Role::create(['name' => 'Cobrador']);
        $cocinaRole = Role::create(['name' => 'Cocina']);
        $contabilidadRole = Role::create(['name' => 'Contabilidad']);

        $user = new user;
        $user->name = 'Super-Administrador';
        $user->email= 'superadministrador@gmail.com';
        $user->password = bcrypt('superadmin');
        $user->username = 'superadmin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($superadminRole); 

        $user = new user;
        $user->name = 'Administrador';
        $user->email= 'administrador@gmail.com';
        $user->password = bcrypt('admin');
        $user->username = 'admin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($adminRole);
        
    }
}
