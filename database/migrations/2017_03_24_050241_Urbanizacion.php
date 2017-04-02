<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Urbanizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('urbanizacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('ref_urbanizacion');
            //TODO: falta id estado 
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
        Schema::dropIfExists('urbanizacion');
    }
}
