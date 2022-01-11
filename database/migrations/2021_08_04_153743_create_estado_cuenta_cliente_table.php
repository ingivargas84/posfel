<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCuentaClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_cuenta_cliente', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->unsignedInteger('factura_maestro_id')->nullable();
            $table->foreign('factura_maestro_id')->references('id')->on('factura_maestro')->onDelete('cascade');

            $table->float('monto')->default(0);
            $table->float('abono')->default(0);
            $table->float('saldo')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_cuenta_cliente');
    }
}
