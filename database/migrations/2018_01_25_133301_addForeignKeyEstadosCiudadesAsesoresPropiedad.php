<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyEstadosCiudadesAsesoresPropiedad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('propiedades', function (Blueprint $table) {
            $table->foreign('agente_id')->references('id')->on('agentes');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('ciudad_id')->references('id')->on('ciudades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propiedades', function (Blueprint $table) {
            $table->dropIfExists('propiedades_agente_id_foreign');
            $table->dropIfExists('propiedades_estado_id_foreign');
            $table->dropIfExists('propiedades_ciudad_id_foreign');
        });
    }
}
