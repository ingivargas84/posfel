<?php

use Illuminate\Database\Seeder;
use App\Tipo_Pago;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $td = new Tipo_Pago();
        $td->tipo_pago = "Crédito";
        $td->save();

        $td = new Tipo_Pago();
        $td->tipo_pago = "Contado";
        $td->save();
    }
}
