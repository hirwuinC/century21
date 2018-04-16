<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompradorPropiedades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compradorPropiedades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comprador_id');
            $table->integer('propiedad_id');
            $table->date('fechaCreado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compradorPropiedades');
    }
}
