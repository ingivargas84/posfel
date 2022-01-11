<?php

use Illuminate\Database\Seeder;
use App\Estado;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $edo = new Estado();
        $edo->descripcion = "Activo";
        $edo->save();

        $edo = new Estado();
        $edo->descripcion = "Inactivo";
        $edo->save();

        $edo = new Estado();
        $edo->descripcion = "Eliminado";
        $edo->save();
    }
}
