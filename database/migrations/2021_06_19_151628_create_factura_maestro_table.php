<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            
            $table->string('correlativo_documento', 20)->nullable()->default(null);
            $table->string('fecha_documento', 20)->nullable()->default(null);

            $table->unsignedInteger('tipo_factura_id')->nullable();
            $table->foreign('tipo_factura_id')->references('id')->on('tipo_factura')->onDelete('cascade');

            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->string('exenta', 5)->nullable()->default(null);

            $table->string('orden_compra')->nullable()->default(null);

            $table->string('envios', 200)->nullable()->default(null);

            $table->unsignedInteger('cotizacion_maestro_id')->nullable();
            $table->foreign('cotizacion_maestro_id')->references('id')->on('cotizacion_maestro')->onDelete('cascade');

            $table->string('transportado_por', 100)->nullable()->default(null);

            $table->float('porcentaje')->nullable()->default(0);
            $table->float('descuento_porcentaje')->nullable()->default(0);
            $table->float('descuento_valores')->nullable()->default(0);
            
            $table->float('total')->default(0);
            $table->float('total_pagado')->default(0);
            $table->float('saldo')->default(0);

            $table->unsignedInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->unsignedInteger('estado_pago_id')->nullable();
            $table->foreign('estado_pago_id')->references('id')->on('estado_pago')->onDelete('cascade');

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
        Schema::dropIfExists('factura_maestro');
    }
}
