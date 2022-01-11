<?php

use Illuminate\Database\Seeder;
use App\EstadoPago;

class EstadoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $edo = new EstadoPago();
        $edo->estado_pago = "Creada";
        $edo->save();

        $edo = new EstadoPago();
        $edo->estado_pago = "Pago Incompleto";
        $edo->save();

        $edo = new EstadoPago();
        $edo->estado_pago = "Pagada";
        $edo->save();

        $edo = new EstadoPago();
        $edo->estado_pago = "Vencida";
        $edo->save();
    }
}
