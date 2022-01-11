<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_detalle', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('orden_compra_maestro_id')->nullable();
            $table->foreign('orden_compra_maestro_id')->references('id')->on('orden_compra_maestro')->onDelete('cascade');

            $table->integer('cantidad')->default(0);

            $table->unsignedInteger('articulo_id')->nullable();
            $table->foreign('articulo_id')->references('id')->on('articulos')->onDelete('cascade');
            $table->string('desc_articulo',255)->nullable()->default(null);
            
            $table->float('precio_unitario')->default(0);
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
        Schema::dropIfExists('orden_compra_detalle');
    }
}
