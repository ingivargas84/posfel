<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nit',25)->nullable()->default(null);
            $table->string('nombre',200)->nullable()->default(null);
            $table->string('direccion',250)->nullable()->default(null);

            $table->unsignedInteger('factura_id')->nullable();
            $table->foreign('factura_id')->references('id')->on('factura_maestro')->onDelete('cascade');

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
        Schema::dropIfExists('factura_cliente');
    }
}
