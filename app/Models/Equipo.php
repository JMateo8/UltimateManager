<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{

    protected $table = "equipos";

    protected $fillable = ["nombre", "user_id"];

    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function ligas(){
        return $this->belongsToMany(Liga::class, "equipo_liga", "equipo_id");
    }

    public function jugadores(){
        return $this->belongsToMany(Jugador::class, "equipo_jornada_jugador", "equipo_id", "jugador_id")
            ->withPivot("jornada_id");
    }

    public function jornadas(){
        return $this->belongsToMany(Jornada::class, "equipo_jornada", "equipo_id", "jornada_id")
            ->withPivot(["puntuacion", "cambios"]);
    }
}
