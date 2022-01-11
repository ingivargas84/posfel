<?php

use Illuminate\Database\Seeder;
use App\TipoFactura;

class TipoFacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $td = new TipoFactura();
        $td->tipo_factura = "Factura de Contado";
        $td->save();

        $td = new TipoFactura();
        $td->tipo_factura = "Factura de Crédito";
        $td->save();
    }
}
