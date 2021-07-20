<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoEuro extends Model
{

    protected $table = "equipo_euro";

    protected $fillable = ["id", "nombre", "pais"];

    protected $primaryKey = "id";

    protected $keyType = "string";

    use HasFactory;

    public function jugadores(){
        return $this->hasMany(Jugador::class, "equipo", "id");
    }
}
