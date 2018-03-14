<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputNegociacionEstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negociacion_estatus', function (Blueprint $table) {
              $table->integer('comisionPaga');
              $table->integer('posicionCancelada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('negociacion_estatus', function (Blueprint $table) {
            $table->dropColumn('comisionPaga');
            $table->dropColumn('posicionCancelada');
        });
    }
}
