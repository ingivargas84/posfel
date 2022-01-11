<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo', 20)->nullable()->default(null);
            $table->string('nombres', 100)->nullable()->default(null);
            $table->string('apellidos', 100)->nullable()->default(null);
            $table->string('dpi', 13)->nullable()->default(null);
            $table->string('puesto', 100)->nullable()->default(null);
            $table->string('direccion', 100)->nullable()->default(null);

            $table->timestamp('fecha_ingreso')->nullable()->default(null);
            $table->float('porcentaje_comision')->nullable()->default(0);
           
            $table->unsignedInteger('user_asignado_id')->nullable();
            $table->foreign('user_asignado_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');

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
        Schema::dropIfExists('vendedores');
    }
}
