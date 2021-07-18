<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EquipoJornadaJugador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_jornada_jugador', function (Blueprint $table) {
            $table->unsignedBigInteger("equipo_id");
            $table->foreign("equipo_id")->references("id")->on("equipos");
            $table->unsignedBigInteger("jugador_id");
            $table->foreign("jugador_id")->references("id")->on("jugador");
            $table->unsignedBigInteger("jornada_id");
            $table->foreign("jornada_id")->references("id")->on("jornada");
            $table->primary(["equipo_id", "jugador_id", "jornada_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_jornada_jugador');
    }
}
