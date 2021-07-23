<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;

    protected $table = "ligas";

    protected $fillable = ["nombre", "admin", "password"];

    public function user(){
        return $this->belongsTo(User::class, "admin", "id");
    }

    public function equipos(){
        return $this->belongsToMany(Equipo::class, "equipo_liga", "liga_id", "equipo_id");
    }
}
