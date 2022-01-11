<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            
            $table->string('correlativo_documento', 20)->nullable()->default(null);
            $table->string('fecha_documento', 20)->nullable()->default(null);

            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->string('anotaciones', 200)->nullable()->default(null);
            $table->string('referencia', 200)->nullable()->default(null);
            $table->string('observaciones', 200)->nullable()->default(null);

            $table->unsignedInteger('tipo_pago_id')->nullable();
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago')->onDelete('cascade');

            $table->string('exenta', 5)->nullable()->default(null);
            $table->string('tiempo_entrega', 50)->nullable()->default(null);
            $table->string('validez_oferta', 100)->nullable()->default(null);
            $table->string('transportado_por', 100)->nullable()->default(null);

            $table->float('descuento_porcentaje')->nullable()->default(0);
            $table->float('porcentaje')->nullable()->default(0);
            $table->float('descuento_valores')->nullable()->default(0);

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
        Schema::dropIfExists('cotizacion_maestro');
    }
}
