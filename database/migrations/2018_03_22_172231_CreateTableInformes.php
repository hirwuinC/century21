<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInformes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_cliente',30);
            $table->date('fechaExclusiva');
            $table->string('promocionRotulo',100);
            $table->string('promocionVolanteo',100);
            $table->string('publicacionVenezuela',50);
            $table->string('publicacionCaracas',50);
            $table->string('publicacionTuInmueble',50);
            $table->string('publicacionLlave',50);
            $table->integer('visitasDigitalesTotales');
            $table->integer('existeCompradores');
            $table->integer('cantidadCompradoresInteresados');
            $table->string('primerInteresado',30);
            $table->string('segundoInteresado',30);
            $table->string('tercerInteresado',30);
            $table->string('cuartoInteresado',30);
            $table->string('quintoInteresado',30);
            $table->integer('existeVisitasFisicas');
            $table->integer('cantidadVisitasFisicas');
            $table->integer('evaluacionCaro');
            $table->integer('evaluacionMalaCondicion');
            $table->integer('evaluacionMalUbicado');
            $table->integer('evaluacionFormaPago');
            $table->integer('evaluacionEnEspera');
            $table->integer('evaluacionVolverVisita');
            $table->integer('evaluacionOtro');
            $table->string('observaciones',250);
            $table->string('recomendaciones',250);
            $table->integer('propiedad_id')->unsigned();
            $table->integer('estatusEnviado');
            $table->date('fechaCreado');
            $table->date('fechaEnviado');
            $table->foreign('propiedad_id')->references('id')->on('propiedades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informes');
    }
}
