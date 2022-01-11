<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_bodegas', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('articulos')->onDelete('cascade');

            $table->unsignedInteger('bodega_id')->nullable();
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');

            $table->string('tipo_movimiento',50)->nullable()->default(null);

            $table->integer('cantidad')->default(0);

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
        Schema::dropIfExists('movimientos_bodegas');
    }
}
