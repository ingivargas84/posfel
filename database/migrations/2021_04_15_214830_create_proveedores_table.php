<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo', 20)->nullable()->default(null);
            
            $table->unsignedInteger('tipo_proveedor_id')->nullable();
            $table->foreign('tipo_proveedor_id')->references('id')->on('tipo_proveedor')->onDelete('cascade');

            $table->string('nombre_comercial', 100)->nullable()->default(null);
            $table->string('razon_social', 100)->nullable()->default(null);
            $table->string('abreviatura', 20)->nullable()->default(null);
            $table->string('prop_replegal', 100)->nullable()->default(null);
            $table->string('nit', 20)->nullable()->default(null);
            $table->string('direccion_comercial', 100)->nullable()->default(null);
            $table->string('telefono', 50)->nullable()->default(null);
            $table->string('correo_electronico', 50)->nullable()->default(null);
            $table->integer('dias_credito')->nullable()->default(0);

            $table->string('cuenta_contable', 100)->nullable()->default(null);

            $table->string('contacto', 100)->nullable()->default(null);
            $table->string('telefono_contacto', 100)->nullable()->default(null);
            
            $table->string('isr', 2)->nullable()->default(null);

            $table->timestamp('fecha_ultima_compra')->default(null);

            $table->string('observaciones', 300)->nullable()->default(null);

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
        Schema::dropIfExists('proveedores');
    }
}
