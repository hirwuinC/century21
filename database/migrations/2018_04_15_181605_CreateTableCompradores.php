<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompradores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compradores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula',25)->unique();
            $table->string('fullNameComprador',100);
            $table->string('email',100);
            $table->unsignedInteger('edad');
            $table->unsignedInteger('sexo');
            $table->string('ocupacion',100);
            $table->unsignedInteger('grupoFamilia');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compradores');
    }
}
