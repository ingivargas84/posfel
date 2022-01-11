<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonoMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_maestro', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('tipo_abono_id')->nullable();
            $table->foreign('tipo_abono_id')->references('id')->on('tipo_abono')->onDelete('cascade');
            
            $table->unsignedInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            
            $table->string('correlativo_documento', 20)->nullable()->default(null);
            $table->string('fecha_documento', 20)->nullable()->default(null);

            $table->string('autorizacion_sat', 200)->nullable()->default(null);          

            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->string('concepto', 200)->nullable()->default(null);
            
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
        Schema::dropIfExists('abono_maestro');
    }
}
