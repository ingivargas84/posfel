<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            
            $table->string('correlativo_documento', 20)->nullable()->default(null);
            $table->string('fecha_documento', 20)->nullable()->default(null);

            $table->unsignedInteger('tipo_documento_importacion_id')->nullable();
            $table->foreign('tipo_documento_importacion_id')->references('id')->on('tipo_documento_importacion')->onDelete('cascade');

            $table->unsignedInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $table->string('atencion_a', 20)->nullable()->default(null);

            $table->unsignedInteger('tipo_pago_id')->nullable();
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago')->onDelete('cascade');

            $table->string('solicito', 100)->nullable()->default(null);
            $table->string('lugar_entrega', 100)->nullable()->default(null);
            $table->timestamp('fecha_entrega')->nullable()->default(null);

            $table->string('observaciones', 200)->nullable()->default(null);

            $table->unsignedInteger('autoriza_id')->nullable();
            $table->foreign('autoriza_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('orden_compra_maestro');
    }
}
