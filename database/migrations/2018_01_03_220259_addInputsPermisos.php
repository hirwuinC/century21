<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputsPermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permisos', function (Blueprint $table) {
            $table->string('class_input');
            $table->string('id_input');
            $table->integer('padre');
            $table->string('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permisos', function (Blueprint $table) {
          $table->dropColumn('class_input');
          $table->dropColumn('id_input');
          $table->dropColumn('padre');
          $table->dropColumn('target');
        });
    }
}
