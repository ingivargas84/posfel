<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');

            $table->string('correlativo_documento', 20)->nullable()->default(null);
            $table->string('fecha_documento', 20)->nullable()->default(null);

            $table->unsignedInteger('tipo_documento_id')->nullable();
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento')->onDelete('cascade');

            $table->unsignedInteger('bodega_origen_id')->nullable();
            $table->foreign('bodega_origen_id')->references('id')->on('bodegas')->onDelete('cascade');

            $table->integer('bodega_destino_id')->nullable()->default(0);

            $table->string('aplicacion', 20)->nullable()->default(null);

            $table->integer('cliente_id')->nullable()->default(0);
            $table->integer('proveedor_id')->nullable()->default(0);
            
            $table->string('observaciones', 200)->nullable()->default(null);
            $table->float('total')->default(0);

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
        Schema::dropIfExists('movimientos_maestro');
    }
}
