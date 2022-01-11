<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('codigo')->nullable()->default(1);

            $table->unsignedInteger('tipo_persona_id')->nullable();
            $table->foreign('tipo_persona_id')->references('id')->on('tipo_persona')->onDelete('cascade');

            $table->string('nombre_comercial', 100)->nullable()->default(null);
            $table->string('razon_social', 100)->nullable()->default(null);
            $table->string('abreviatura', 10)->nullable()->default(null);
            $table->string('nit', 15)->nullable()->default(null);
            $table->string('prop_replegal', 100)->nullable()->default(null);
            $table->string('direccion_comercial', 150)->nullable()->default(null);
            $table->string('telefono', 30)->nullable()->default(null);
            $table->string('nombre_contacto', 100)->nullable()->default(null);
            $table->string('telefono_contacto', 30)->nullable()->default(null);
            $table->string('correo_electronico', 50)->nullable()->default(null);
            $table->string('lugar_entrega', 50)->nullable()->default(null);

            $table->unsignedInteger('vendedor_id')->nullable();
            $table->foreign('vendedor_id')->references('id')->on('vendedores')->onDelete('cascade');

            $table->integer('limite_credito')->nullable()->default(0);
            $table->float('saldo_actual')->nullable()->default(0);
            $table->integer('dias_credito')->nullable()->default(0);
            $table->float('descuento_autorizado')->nullable()->default(0);
            $table->string('cuenta_contable')->nullable()->default(null);
            $table->timestamp('fecha_ultima_venta')->nullable()->default(null);
            $table->string('retenedor_iva', 2)->nullable()->default(null);
            $table->string('observaciones', 200)->nullable()->default(null);

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
        Schema::dropIfExists('clientes');
    }
}

