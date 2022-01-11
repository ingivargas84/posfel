<?php

use Illuminate\Database\Seeder;
use App\Tipo_Transporte;

class TipoTransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tp = new Tipo_Transporte();
        $tp->tipo_transporte = "Inland/Terrestre";
        $tp->save();

        $tp = new Tipo_Transporte();
        $tp->tipo_transporte = "Ocean Freigth/Marítimo";
        $tp->save();
    }
}
