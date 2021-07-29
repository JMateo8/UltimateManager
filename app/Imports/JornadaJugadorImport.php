<?php

namespace App\Imports;

use App\Models\Jornada;
use App\Models\JornadaJugador;
use Maatwebsite\Excel\Concerns\ToModel;

class JornadaJugadorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JornadaJugador([
            'jugador_id' => $row[0],
            'valoracion' => $row[1],
            'jornada_id' => Jornada::where("actual", 1)->get()->pluck("id")->toArray()[0],
        ]);
    }
}
