<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = "jugador";

    public function equipos(){
        return $this->belongsToMany(Equipo::class, "equipo_jornada_jugador", "jugador_id", "equipo_id")
            ->withPivot("jornada_id");
    }

    public function jornadas(){
        return $this->belongsToMany(Jornada::class, "jornada_jugador", "jugador_id", "jornada_id")
            ->withPivot("valoracion");
    }

}
