<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_roles', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('perfil_id')->nullable();
            $table->foreign('perfil_id')->references('id')->on('perfiles')->onDelete('cascade');

            $table->unsignedInteger('rol_id')->nullable();
            $table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');

            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');

            $table->unsignedInteger('user_asigna_id')->nullable();
            $table->foreign('user_asigna_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('perfil_roles');
    }
}
