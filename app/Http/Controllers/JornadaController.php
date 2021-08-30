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

    public function siguienteJornada(Request $request){
        /*
         * Recogemos el valor de la jornada de la variable request,
         * buscamos su instancia con el método find(),
         * le cambiamos el atributo actual a 0 y guardamos */
        $jornadaId = $request->jornada;
        $jornada = Jornada::find($jornadaId);
        $jornada->actual = 0;
        $jornada->save();

        $newJornadaId = $jornadaId + 1;

        /*
         * Intentamos buscar en la BBDD la jornada siguiente.
         * Si la encuentra, le actualizamos su atributo actual a 1
         * Sino crea una instancia nueva con el ID posterior, nombre,
         * valor de cerrada como 0 y de actual como 1 */
        $newJornada = Jornada::firstOrCreate([
            "id" => $newJornadaId
        ], [
            "nombre" => "Jornada " . $newJornadaId,
            "cerrada" => 0
        ]);
        $newJornada->actual = 1;
        $newJornada->save();

        /*
        * Traspasamos los equipos y los jugadores de los equipos de una jornada a la siguiente
        * y volvemos a la página anterior */
        foreach (Equipo::all() as $equipo) {
            $equipo->jornadas()->attach($newJornadaId);
            foreach ($equipo->jugadores->where("pivot.jornada_id", $jornadaId) as $jugador) {
                $equipo = Equipo::find($jugador->pivot->equipo_id);
                $equipo->jugadores()->attach($jugador->pivot->jugador_id, ["jornada_id" => $newJornadaId]);
            }
        }

        return back();
    }
}
