<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;

    protected $fillable = ["id", "nombre", "actual", "cerrada"];

    protected $table = "jornada";

    public $timestamps = false;

    public function equipos(){
        return $this->belongsToMany(Equipo::class, "equipo_jornada", "jornada_id", "equipo_id")
            ->withPivot(["puntuacion", "cambios"]);
    }

    public function jugadores(){
        return $this->belongsToMany(Jugador::class, "jornada_jugador", "jornada_id", "jugador_id")
            ->withPivot("valoracion");
    }
}
