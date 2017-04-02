<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Oficina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('oficina', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');

            $table->string('email');
            $table->integer('ref_ofic');
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
        Schema::dropIfExists('oficina');
    }
}
