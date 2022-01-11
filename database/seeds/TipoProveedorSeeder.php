<?php

use Illuminate\Database\Seeder;
use App\Tipo_Proveedor;

class TipoProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tp = new Tipo_Proveedor();
        $tp->tipo_proveedor = "Local";
        $tp->save();

        $tp = new Tipo_Proveedor();
        $tp->tipo_proveedor = "Exterior";
        $tp->save();
    }
}
