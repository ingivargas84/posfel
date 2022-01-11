<?php

use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $up = new Empresa();
        $up->codigo = "000";
        $up->tipo_persona_id = 1;
        $up->nombre_comercial = "VR Infosys";
        $up->razon_social = "VR Infosys";
        $up->abreviatura = "VRIS";
        $up->nit = "28818059";
        $up->num_patronal_igss = "123456789";
        $up->direccion_comercial = "Guatemala";
        $up->direccion_fiscal = "Guatemala";
        $up->prop_replegal = "Iver Vargas";
        $up->nit_prop_replegal = "28818059";
        $up->nombre_contador = "Gabriela Godinez";
        $up->nit_contador = "50291173";
        $up->user_id = 1;
        $up->estado_id = 1;
        $up->save();
    }
}
