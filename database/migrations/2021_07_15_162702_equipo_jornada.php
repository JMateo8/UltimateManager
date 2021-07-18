<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EquipoJornada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_jornada', function (Blueprint $table) {
            $table->unsignedBigInteger("equipo_id");
            $table->foreign("equipo_id")->references("id")->on("equipos");
            $table->unsignedBigInteger("jornada_id");
            $table->foreign("jornada_id")->references("id")->on("jornada");
            $table->double("puntuacion")->default(0);
            $table->primary(["equipo_id", "jornada_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_jornada');
    }

}
