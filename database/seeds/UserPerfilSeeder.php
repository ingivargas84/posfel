<?php

use Illuminate\Database\Seeder;
use App\User_Perfil;

class UserPerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $up = new User_Perfil();
        $up->user_id = 1;
        $up->perfil_id = 1;
        $up->empresa_id = 1;
        $up->estado_id = 1;
        $up->user_asigna_id = 1;
        $up->save();
    }
}
