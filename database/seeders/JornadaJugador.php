<?php

namespace Database\Seeders;

use App\Models\Jornada;
use App\Models\Jugador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JornadaJugador extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Jugador::all() as $jugador){
            $jugador->jornadas()->attach(Jornada::where("actual", 1)->first()->id, ["valoracion" => rand(0,40)]);
        }
    }
}
