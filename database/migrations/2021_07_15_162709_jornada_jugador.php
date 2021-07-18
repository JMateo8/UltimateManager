<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JornadaJugador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada_jugador', function (Blueprint $table) {
            $table->unsignedBigInteger("jugador_id");
            $table->foreign("jugador_id")->references("id")->on("jugador");
            $table->unsignedBigInteger("jornada_id");
            $table->foreign("jornada_id")->references("id")->on("jornada");
            $table->double("valoracion");
            $table->primary(["jugador_id", "jornada_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornada_jugador');
    }

}
