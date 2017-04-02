<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Estado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('estado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');

            $table->string('cedula');
            $table->string('pasaporte');
            $table->string('direccion');
            $table->integer('ref_estado');
            //TODO: falta id propiedad 1 a 1 nulleable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('estado');
    }
}
