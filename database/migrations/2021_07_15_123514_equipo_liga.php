<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EquipoLiga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_liga', function (Blueprint $table) {
            $table->unsignedBigInteger("liga_id");
            $table->foreign("liga_id")->references("id")->on("ligas");
            $table->unsignedBigInteger("equipo_id");
            $table->foreign("equipo_id")->references("id")->on("equipos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligas');
    }
}
