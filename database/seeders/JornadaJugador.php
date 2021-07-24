<?php

namespace Database\Seeders;

use App\Models\Jornada;
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
        for ($i=1; $i<=95; $i++){
            DB::table('jornada_jugador')->insert([
                'jugador_id' => $i,
                'jornada_id' => Jornada::where("actual", 1)->get()->pluck("id")->toArray()[0], //Jornada actual
                'valoracion' => rand(0,35),
            ]);
        }
    }
}
