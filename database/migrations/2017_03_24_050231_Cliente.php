<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName');
            $table->string('cedula');
            $table->string('pasaporte');
            $table->string('direccion');
            $table->integer('ref_prop');
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
        Schema::dropIfExists('cliente');
    }
}
