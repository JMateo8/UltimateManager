<?php

namespace App\Imports;

use App\Models\Jornada;
use App\Models\JornadaJugador;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JornadaJugadorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JornadaJugador([
            'jugador_id' => $row['jugador_id'],
            'valoracion' => $row['valoracion'],
            'jornada_id' => Jornada::where("actual", 1)->first()->id,
        ]);
    }
}
