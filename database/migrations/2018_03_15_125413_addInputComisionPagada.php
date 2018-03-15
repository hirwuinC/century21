<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputComisionPagada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negociaciones', function (Blueprint $table) {
            $table->integer('comisionPagada');
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
            $table->dropColumn('comisionPagada');
        });
    }
}
