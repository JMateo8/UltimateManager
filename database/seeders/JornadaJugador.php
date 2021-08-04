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
//        for ($i=1; $i<=95; $i++){
//            DB::table('jornada_jugador')->insert([
//                'jugador_id' => $i,
//                'jornada_id' => Jornada::where("actual", 1)->first()->id, //Jornada actual
//                'valoracion' => rand(0,35),
//            ]);
//        }
    }
}
