<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnulaFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anula_factura', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('factura_maestro_id')->nullable();
            $table->foreign('factura_maestro_id')->references('id')->on('factura_maestro')->onDelete('cascade');

            $table->string('razon_anulacion', 50)->nullable()->default(null);

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('anula_factura');
    }
}
