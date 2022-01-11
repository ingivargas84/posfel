<?php

use Illuminate\Database\Seeder;
use App\Tipo_Documento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $td = new Tipo_Documento();
        $td->tipo_documento = "Entrada";
        $td->save();

        $td = new Tipo_Documento();
        $td->tipo_documento = "Salida";
        $td->save();

        $td = new Tipo_Documento();
        $td->tipo_documento = "Traslado";
        $td->save();
    }
}
