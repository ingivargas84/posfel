<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo_articulo', 20)->nullable()->default(null);
            $table->string('codigo_alterno', 20)->nullable()->default(null);
            $table->string('descripcion', 200)->nullable()->default(null);

            $table->unsignedInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $table->float('costo_fob')->nullable()->default(0);
            $table->float('costo_dolares')->nullable()->default(0);
            $table->float('costo_quetzales')->nullable()->default(0);
            $table->float('costo_promedio_quetzales')->nullable()->default(0);
            $table->float('ultimo_costo')->nullable()->default(0);
            $table->float('primer_costo')->nullable()->default(0);

            $table->float('precio_quetzales')->nullable()->default(0);
            $table->float('precio_dolares')->nullable()->default(0);
            $table->float('ultimo_precio')->nullable()->default(0);
            $table->integer('existencia')->nullable()->default(0);
            $table->float('cantidad_pedida')->nullable()->default(0);
            $table->float('cantidad_minima')->nullable()->default(0);
            $table->float('cantidad_maxima')->nullable()->default(0);
            $table->timestamp('fecha_ultima_compra')->nullable()->default(null);
            $table->timestamp('fecha_ultima_venta')->nullable()->default(null);

            $table->string('localizacion', 100)->nullable()->default(null);

            $table->unsignedInteger('bodega_id')->nullable();
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');
            
            $table->string('almacenadora', 100)->nullable()->default(null);
            $table->string('observaciones', 100)->nullable()->default(null);

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
        Schema::dropIfExists('articulos');
    }
}
