<?php

use Illuminate\Database\Seeder;
use App\Rol;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r = new Rol();
        $r->codigo = "001";
        $r->descripcion = "Crea Empresa";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "002";
        $r->descripcion = "Edita Empresa";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "003";
        $r->descripcion = "Observa Empresa";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "004";
        $r->descripcion = "Activa/Desactiva Empresa";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "005";
        $r->descripcion = "Elimina Empresa";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "006";
        $r->descripcion = "Crea Bodega";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "007";
        $r->descripcion = "Edita Bodega";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "008";
        $r->descripcion = "Observa Bodega";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "009";
        $r->descripcion = "Activa/Desactiva Bodega";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "010";
        $r->descripcion = "Elimina Bodega";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r->codigo = "011";
        $r->descripcion = "Crea Artículos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "012";
        $r->descripcion = "Edita Artículos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "013";
        $r->descripcion = "Observa Artículos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "014";
        $r->descripcion = "Activa/Desactiva Artículos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "015";
        $r->descripcion = "Elimina Artículos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r->codigo = "016";
        $r->descripcion = "Crea Documentos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "017";
        $r->descripcion = "Edita Documentos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "018";
        $r->descripcion = "Observa Documentos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "019";
        $r->descripcion = "Activa/Desactiva Documentos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "020";
        $r->descripcion = "Elimina Documentos";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r->codigo = "021";
        $r->descripcion = "Crea Provedores";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "022";
        $r->descripcion = "Edita Proveedores";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "023";
        $r->descripcion = "Observa Proveedores";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "024";
        $r->descripcion = "Activa/Desactiva Proveedores";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();

        $r = new Rol();
        $r->codigo = "025";
        $r->descripcion = "Elimina Proveedores";
        $r->user_id = 1;
        $r->estado_id = 1;
        $r->save();
    }
}
