<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JornadaJugador extends Pivot
{
    protected $table = 'jornada_jugador';

    protected $fillable = ["jugador_id", "jornada_id", "valoracion"];

    public $timestamps = false;

}
