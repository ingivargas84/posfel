<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importaciones_detalle', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('importacion_maestro_id')->nullable();
            $table->foreign('importacion_maestro_id')->references('id')->on('importaciones_maestro')->onDelete('cascade');

            $table->integer('cantidad')->default(0);

            $table->unsignedInteger('articulo_id')->nullable();
            $table->foreign('articulo_id')->references('id')->on('articulos')->onDelete('cascade');
            
            $table->float('fob')->default(0);
            $table->float('subtotal')->default(0);

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
        Schema::dropIfExists('importaciones_detalle');
    }
}
