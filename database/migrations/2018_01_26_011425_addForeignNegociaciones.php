<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignNegociaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negociaciones', function (Blueprint $table) {
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
        Schema::table('negociaciones', function (Blueprint $table) {
            $table->dropIfExists('negociaciones_propiedad_id_foreign');
        });
    }
}
