<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUrbanizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('urbanizaciones', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nombre');
          $table->unsignedInteger('ciudad_id');
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
        Schema::dropIfExists('urbanizaciones');
    }
}
