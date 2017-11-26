<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Propiedad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_msl');
            $table->string('tipo_inmueble');
            $table->string('urbanizacion');
            $table->integer('precio');
            $table->integer('habitaciones');
            $table->integer('banos');
            $table->integer('estacionamientos');
            $table->integer('metros_construccion');
            $table->integer('metros_terreno');
            $table->string('comentario');
            $table->integer('agente_id');
            $table->integer('ciudad_id');
            $table->integer('media_id');
            $table->integer('oficina_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propiedades');
    }
}
