<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoNegocio',30);
            $table->string('nombreProyecto',30);
            $table->unsignedInteger('metrosConstruccion');
            $table->date('fechaEntrega');
            $table->unsignedInteger('estado_id');
            $table->unsignedInteger('ciudad_id');
            $table->string('direccionProyecto',100);
            $table->string('descripcionProyecto',300);
            $table->string('posicionMapa',100);
            $table->unsignedInteger('visitas');
            $table->unsignedInteger('compradorInteresado');
            $table->unsignedInteger('cargado');
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
        Schema::dropIfExists('proyectos');
    }
}
