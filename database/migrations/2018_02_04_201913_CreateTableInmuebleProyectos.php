<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInmuebleProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmuebleProyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tipoinmueble_id');
            $table->unsignedInteger('cantidad');
            $table->unsignedInteger('precio');
            $table->unsignedInteger('visible');
            $table->unsignedInteger('metrosConstruccion');
            $table->unsignedInteger('habitaciones');
            $table->unsignedInteger('banos');
            $table->unsignedInteger('estacionamientos');
            $table->string('descripcionInmueble',300);
            $table->unsignedInteger('proyecto_id');
            $table->foreign('tipoinmueble_id')->references('id')->on('tipoInmuebleProyectos');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inmuebleProyectos');
    }
}
