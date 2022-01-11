<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_detalle', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('abono_maestro_id')->nullable();
            $table->foreign('abono_maestro_id')->references('id')->on('abono_maestro')->onDelete('cascade');

            $table->unsignedInteger('factura_maestro_id')->nullable();
            $table->foreign('factura_maestro_id')->references('id')->on('factura_maestro')->onDelete('cascade');

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
        Schema::dropIfExists('abono_detalle');
    }
}
