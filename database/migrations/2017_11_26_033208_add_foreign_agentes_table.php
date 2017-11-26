<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignAgentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentes',function(Blueprint $table){
            $table->integer('imagen_id')->unsigned()->change();
            $table->foreign('imagen_id')->references('id')->on('imagenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agentes',function(BLueprint $table){
            $table->dropForeign('agentes_imagen_id_foreign');
        });
    }
}
