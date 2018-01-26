<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNegociacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negociaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asesorCaptador_id')->unsigned();
            $table->integer('asesorCerrador_id')->unsigned();
            $table->integer('precioFinal')->unsigned();
            $table->float('porcentajeCaptacion');
            $table->float('porcentajeCierre');
            $table->float('comisionBruta');
            $table->float('pagoCasaMatriz');
            $table->float('ingresoNeto');
            $table->timestamps();
            $table->foreign('asesorCaptador_id')->references('id')->on('agentes');
            $table->foreign('asesorCerrador_id')->references('id')->on('agentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('negociaciones');
    }
}
