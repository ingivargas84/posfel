<?php

use Illuminate\Database\Seeder;
use App\Tipo_Persona;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tp = new Tipo_Persona();
        $tp->descripcion = "Natural";
        $tp->save();

        $tp = new Tipo_Persona();
        $tp->descripcion = "Jurídica";
        $tp->save();
    }
}
