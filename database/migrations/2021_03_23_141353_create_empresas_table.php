<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 20)->nullable()->default(null);
            
            $table->unsignedInteger('tipo_persona_id')->nullable();
            $table->foreign('tipo_persona_id')->references('id')->on('tipo_persona')->onDelete('cascade');

            $table->string('nombre_comercial', 100)->nullable()->default(null);
            $table->string('razon_social', 100)->nullable()->default(null);
            $table->string('abreviatura', 10)->nullable()->default(null);
            $table->string('nit', 15)->nullable()->default(null);
            $table->string('num_patronal_igss', 20)->nullable()->default(null);
            $table->string('direccion_comercial', 150)->nullable()->default(null);
            $table->string('direccion_fiscal', 150)->nullable()->default(null);
            $table->string('prop_replegal', 100)->nullable()->default(null);
            $table->string('nit_prop_replegal', 100)->nullable()->default(null);
            $table->string('nombre_contador', 100)->nullable()->default(null);
            $table->string('nit_contador', 100)->nullable()->default(null);

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            
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
        Schema::dropIfExists('empresas');
    }
}
