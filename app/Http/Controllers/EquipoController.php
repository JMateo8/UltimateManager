<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipo;
use App\Models\Equipo;
use App\Models\Jornada;
use App\Models\Jugador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $equipos = Equipo::where("user_id", auth()->id())
            ->with("ligas")
            ->withCount([
            'jugadores' => function ($query) use($jornada_actual) {
                $query->where('jornada_id', $jornada_actual);
            }])
            ->get();
        //$equipos = User::find(\auth()->id())->equipos;
        return view("cliente.equipo.listado", ["equipos" => $equipos, "jornada_actual" => $jornada_actual]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cliente.equipo.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipo $request)
    {
        $equipo = new Equipo($request->input());
        $equipo->save();
        //return redirect()->route("equipo.index")->with('status', "¡Equipo $equipo->nombre creado!");
        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Equipo $equipo->nombre creado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {
        if ($equipo->user_id === \auth()->id()){
            $jornadaObj = Jornada::where("actual", 1)->first();
            $jornada_actual = Jornada::where("actual", 1)->first()->id;
            $jugadores = $equipo->jugadores->where("pivot.jornada_id", $jornada_actual)->sortByDesc("precio");
                //->load(["jornadas"], "equipo_euro");
            info($jugadores);
            info($jornadaObj);
            $cambios = $equipo->jornadas()->wherePivot("jornada_id", $jornada_actual)->first()->pivot->cambios;
    //        $jugadores = [];
    //        foreach ($jugadoresPivot as $jugador){
    //            if ($jugador->pivot["jornada_id"] === $jornada_actual[0]){
    //                $jugadores[] = $jugador;
    //            }
    //        }
            return view("cliente.equipo.show", ["cambios" => $cambios, "equipo" => $equipo, "jugadores" => $jugadores, "jornadaObj" => $jornadaObj, "jornada" => $jornada_actual, "jornada_actual" => $jornada_actual]);
        } else {
            return back()->withErrors(["error" => "Este equipo no es tuyo"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipo $equipo)
    {
        $equipoId = $equipo->id;
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $jugEq = $equipo->jugadores->where("pivot.jornada_id", $jornada_actual)->pluck("id");
        $cambios = $equipo->jornadas()->wherePivot("jornada_id", $jornada_actual)->first()->pivot->cambios;
//        $jugEq = Jugador::join("equipo_jornada_jugador", "jugadors.id", "=", "equipo_jornada_jugador.id_jugador")
//            ->where("equipo_jornada_jugador.id_equipo", $equipo->id)
//            ->where("equipo_jornada_jugador.jornada", env("JORNADA_ACTUAL"))
//            ->get(["jugadors.id"])->pluck("id")->toArray();
//        $jugEq = Jugador::join("equipo_jugador", "jugadors.id", "=", "equipo_jugador.id_jugador")
//            ->where("equipo_jugador.id_equipo", $equipoId)
//            ->get(["jugadors.id"])->pluck("id")->toArray();

        if (count($jugEq)>=10){
            return redirect()->route("equipo.index")->withErrors(["error" => "Límite de jugadores superado"]);
        } else {
            $jugadores = Jugador::with("equipo_euro")->where("precio", "<", $equipo->dinero)->orderByDesc("val_media")->get();
            return view("cliente.equipo.add", [
                "jugadores" => $jugadores,
                "jornada" => $jornada_actual,
                "jugEq" => $jugEq,
                "id" => $equipoId,
                "equipo" => $equipo]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipo $equipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route("equipo.index")->with('status', "¡Equipo $equipo->nombre eliminado!");
    }

//    public function showJornada(Request $request){
//        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
//        $jornada = $request->jornada;
//        $equipo = Equipo::find($request->equipo);
//        $jugadores = $equipo->jugadores->where("pivot.jornada_id", $jornada)->sortBy("nombre");
////        $jugadores = [];
////        foreach ($jugadoresPivot as $jugador){
////            if ($jugador->pivot["jornada_id"] === $jornada){
////                $jugadores[] = $jugador;
////            }
////        }
//        return view("cliente.equipo.show", ["equipo" => $equipo, "jugadores" => $jugadores, "jornada" => $jornada, "jornada_actual" => $jornada_actual[0]]);
//    }

    public function showJornada(Request $request, Equipo $equipo){
        $jornadaObj = Jornada::where("actual", 1)->first();
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $cambios = $equipo->jornadas()->wherePivot("jornada_id", $jornada_actual)->first()->pivot->cambios;
        $jornada = $request->jornada;
        $jugadores = $equipo->jugadores->where("pivot.jornada_id", $jornada)->sortByDesc("precio");
        return view("cliente.equipo.show", ["cambios" => $cambios, "equipo" => $equipo, "jugadores" => $jugadores, "jornada" => $jornada, "jornadaObj" => $jornadaObj, "jornada_actual" => $jornada_actual]);
    }

    public function fichar(Request $request){
        $equipo = Equipo::find($request->equipo);
        $jugador = Jugador::find($request->jugador);
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $equipo->jugadores()->attach($jugador, ["jornada_id" => $jornada_actual]);
        $equipo->decrement("dinero", $jugador->precio);
//        DB::table("equipo_jornada_jugador")->insert([
//            "equipo_id" => $equipo->id,
//            "jugador_id" => $jugador->id,
//            "jornada_id" => $jornada_actual[0]
//        ]);
//        DB::table("equipo_jornada_jugador")->where('id_equipo', $equipo->id)
//            ->where('id_jugador', $jugador->id)
//            ->update(['jornada' => env("JORNADA_ACTUAL")]);
        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Jugador $jugador->nombre fichado!");
    }

//    public function detach(Request $request){
//        $equipo = Equipo::find($request->equipo);
//        $jugador = Jugador::find($request->jugador);
//        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
//        //$equipo->jugadores()->detach($jugador->id);
//        DB::table("equipo_jornada_jugador")
//            ->where([
//                ['equipo_id', '=', $equipo->id],
//                ['jugador_id', '=', $jugador->id],
//                ['jornada_id', '=', $jornada_actual[0]]
//            ])
//            ->delete();
//
//        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Jugador $jugador->nombre vendido!");
//    }

    public function vender(Equipo $equipo, Jugador $jugador){
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual)->detach($jugador);
        $equipo->jornadas()->wherePivot("jornada_id", $jornada_actual)->increment("cambios", 1);
        $equipo->increment("dinero", $jugador->precio);
//        DB::table("equipo_jornada_jugador")
//            ->where([
//                ['equipo_id', '=', $equipo->id],
//                ['jugador_id', '=', $jugador->id],
//                ['jornada_id', '=', $jornada_actual[0]]
//            ])
//            ->delete();

//        DB::table("equipo_jornada")
//            ->where([
//                ["equipo_id", $equipo->id],
//                ["jornada_id", $jornada_actual[0]]
//            ])
//            ->increment("cambios", 1);

        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Jugador $jugador->nombre vendido!");
    }

    public function anularCambios(Equipo $equipo){
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        /** Jugadores de la jornada actual, que quitamos de la plantilla */
        $jugadoresActuales = $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual)->pluck("id");
        $preciosActuales = $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual)->pluck("precio")->toArray();
        $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual)->detach($jugadoresActuales, ["jornada_id" => $jornada_actual]);
        /** Jugadores de la jornada anterior, que añadimos a la plantilla */
        $jugadoresNew = $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual-1)->pluck("id");
        $preciosNew = $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual-1)->pluck("precio")->toArray();
        $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual)->attach($jugadoresNew, ["jornada_id" => $jornada_actual]);
        /** Cambios a 0 y  dinero */
        $equipo->jornadas()->wherePivot("jornada_id", $jornada_actual)->update(["cambios" => 0]);
        info($equipo->dinero);
        info($preciosNew);
        info(array_sum($preciosNew));
        info($preciosActuales);
        info(array_sum($preciosActuales));
        $equipo->dinero = $equipo->dinero - array_sum($preciosNew) + array_sum($preciosActuales);
        $equipo->save();
        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Cambios anulados!");
    }
}
