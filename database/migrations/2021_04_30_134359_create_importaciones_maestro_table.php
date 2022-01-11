<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importaciones_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->string('no_hoja', 20)->nullable()->default(null);
            $table->string('no_pedido', 20)->nullable()->default(null);

            $table->string('orden_compra_id', 20)->nullable()->default(null);

            $table->unsignedInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $table->timestamp('fecha')->nullable()->default(null);
            $table->string('poliza', 50)->nullable()->default(null);
            $table->string('no_factura', 50)->nullable()->default(null);
            $table->string('tipo_mercaderia', 100)->nullable()->default(null);

            $table->unsignedInteger('tipo_transporte_id')->nullable();
            $table->foreign('tipo_transporte_id')->references('id')->on('tipo_transporte')->onDelete('cascade');

            $table->float('valor_fob')->nullable()->default(0);
            $table->float('costo_transporte')->nullable()->default(0);
            $table->float('consular_fees')->nullable()->default(0);
            $table->float('bl_pc')->nullable()->default(0);
            $table->float('insurance')->nullable()->default(0);
            $table->float('others')->nullable()->default(0);
            $table->float('handling_and_po')->nullable()->default(0);           
            $table->float('total_cif')->nullable()->default(0);

            $table->float('tasa_cambio')->nullable()->default(0);
            $table->float('quetzalizacion')->nullable()->default(0);

            $table->float('d_arancelarios_imp')->nullable()->default(0);
            $table->float('multas')->nullable()->default(0);
            $table->float('almacenaje_algesa')->nullable()->default(0);
            $table->float('marchamo')->nullable()->default(0);
            $table->float('muellaje')->nullable()->default(0);
            $table->float('fumigacion')->nullable()->default(0);
            $table->float('m_documentacion')->nullable()->default(0);
            $table->float('tram_al')->nullable()->default(0);
            $table->float('hono_aa')->nullable()->default(0);
            $table->float('formulario')->nullable()->default(0);
            $table->float('fl_i_a_v')->nullable()->default(0);
            $table->float('fl_i_c_v')->nullable()->default(0);
            $table->float('fl_ch_bv')->nullable()->default(0);
            $table->float('d_monta')->nullable()->default(0);         
            $table->float('viaticos')->nullable()->default(0);
            $table->float('otros')->nullable()->default(0);         
            
            $table->float('costo_pbod')->nullable()->default(0);
            $table->float('fac_costeo')->nullable()->default(0);
            
            $table->float('total')->nullable()->default(0);

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
        Schema::dropIfExists('importaciones_maestro');
    }
}
