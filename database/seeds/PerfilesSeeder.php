<?php

use Illuminate\Database\Seeder;
use App\Perfil;

class PerfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Perfil();
        $p->codigo = "001";
        $p->descripcion = "Administrador";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "002";
        $p->descripcion = "Gerencia General";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "003";
        $p->descripcion = "Contador General";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "004";
        $p->descripcion = "Auditor Externo";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "005";
        $p->descripcion = "Auxiliar de Contabilidad";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "006";
        $p->descripcion = "Gerencia de Ventas";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "007";
        $p->descripcion = "Vendedor";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();

        $p = new Perfil();
        $p->codigo = "008";
        $p->descripcion = "Bodeguero";
        $p->user_id = 1;
        $p->estado_id = 1;
        $p->save();
    }


}
