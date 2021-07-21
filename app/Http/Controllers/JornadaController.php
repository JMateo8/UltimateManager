<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jornada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JornadaController extends Controller
{
    public function cerrarJornada(Request $request){
        /*
         * Recogemos el valor de la jornada de la variable request
         * y buscamos su instancia con el método find() */
        $jornada = Jornada::find($request->jornada);
        /*
         * A la jornada le cambiamos el atributo cerrada a 1,
         * la guardamos con el método save
         * y volvemos a la página anterior() */
        $jornada->cerrada = 1;
        $jornada->save();
        return back();
    }

    public function siguienteJornada(){
        /* Cogemos*/
        $jornadaId = Jornada::where("actual", 1)->pluck("id")->toArray()[0];
        $jornada = Jornada::find($jornadaId);
        $jornada->actual = 0;
        $jornada->save();

        $newJornadaId = $jornadaId + 1;
        $newJornada = Jornada::firstOrCreate([
            "id" => $newJornadaId
        ], [
            "nombre" => "Jornada " . $newJornadaId,
            "actual" => 1,
            "cerrada" => 0
        ]);
        $newJornada->actual = 1;
        $newJornada->save();

        foreach (Equipo::all() as $equipo) {
            foreach ($equipo->jugadores->where("pivot.jornada_id", $jornadaId) as $jugador) {
                DB::table("equipo_jornada_jugador")->insert([
                    "equipo_id" => $jugador->pivot->equipo_id,
                    "jugador_id" => $jugador->pivot->jugador_id,
                    "jornada_id" => $newJornadaId
                ]);
            }
        }

        return back();
    }
}
