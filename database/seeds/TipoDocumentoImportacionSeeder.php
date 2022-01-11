<?php

use Illuminate\Database\Seeder;
use App\Tipo_Documento_Importacion;

class TipoDocumentoImportacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $td = new Tipo_Documento_Importacion();
        $td->tipo_documento_importacion = "Local";
        $td->save();

        $td = new Tipo_Documento_Importacion();
        $td->tipo_documento_importacion = "Importación";
        $td->save();
    }
}
