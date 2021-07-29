<?php

namespace App\Exports;

use App\Models\JornadaJugador;
use Maatwebsite\Excel\Concerns\FromCollection;

class JornadaJugadorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JornadaJugador::all();
    }
}
