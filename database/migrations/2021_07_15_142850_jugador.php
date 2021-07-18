<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jugador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugador', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('equipo', 3);
            $table->string('posición', 10);
            $table->string('pais', 3);
            $table->smallInteger('altura');
            $table->smallInteger('edad');

            $table->foreign("equipo")->references("id")->on("equipo_euro");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jugador');
    }
}
