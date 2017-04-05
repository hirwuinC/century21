<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Agente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('agentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName');
            $table->string('email');
            $table->string('telefono');
            $table->string('celular');
            $table->integer('ref_id');
            $table->integer('imagen_id');
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
        Schema::dropIfExists('agente');
    }
}
