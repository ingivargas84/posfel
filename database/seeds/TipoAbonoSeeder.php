<?php

use Illuminate\Database\Seeder;
use App\TipoAbono;

class TipoAbonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $td = new TipoAbono();
        $td->tipo_abono = "Recibo";
        $td->save();

        $td = new TipoAbono();
        $td->tipo_abono = "Nota de Crédito";
        $td->save();

        $td = new TipoAbono();
        $td->tipo_abono = "Retención";
        $td->save();
    }
}
