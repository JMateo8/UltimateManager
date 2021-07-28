<?php

namespace App\Http\Controllers;

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
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $equipos = Equipo::where("user_id", auth()->id())
            ->with("ligas")
            ->withCount([
            'jugadores' => function ($query) use($jornada_actual) {
                $query->where('jornada_id', $jornada_actual[0]);
            }])
            ->get();
        //$equipos = User::find(\auth()->id())->equipos;
        return view("cliente.equipo.listado", ["equipos" => $equipos, "jornada_actual" => $jornada_actual[0]]);
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
    public function store(Request $request)
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
            $jornada_actual = Jornada::where("actual", 1)->pluck("id");
            $jugadores = $equipo->jugadores->where("pivot.jornada_id", $jornada_actual[0])->sortByDesc("precio");
                //->load(["jornadas"], "equipo_euro");
            info($jugadores);
            info($jornadaObj);
    //        $jugadores = [];
    //        foreach ($jugadoresPivot as $jugador){
    //            if ($jugador->pivot["jornada_id"] === $jornada_actual[0]){
    //                $jugadores[] = $jugador;
    //            }
    //        }
            return view("cliente.equipo.show", ["equipo" => $equipo, "jugadores" => $jugadores, "jornadaObj" => $jornadaObj, "jornada" => $jornada_actual[0], "jornada_actual" => $jornada_actual[0]]);
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
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $jugEq = $equipo->jugadores->where("pivot.jornada_id", $jornada_actual[0])->pluck("id");
//        $jugEq = Jugador::join("equipo_jornada_jugador", "jugadors.id", "=", "equipo_jornada_jugador.id_jugador")
//            ->where("equipo_jornada_jugador.id_equipo", $equipo->id)
//            ->where("equipo_jornada_jugador.jornada", env("JORNADA_ACTUAL"))
//            ->get(["jugadors.id"])->pluck("id")->toArray();
//        $jugEq = Jugador::join("equipo_jugador", "jugadors.id", "=", "equipo_jugador.id_jugador")
//            ->where("equipo_jugador.id_equipo", $equipoId)
//            ->get(["jugadors.id"])->pluck("id")->toArray();

        if (count($jugEq)>=10){
            return redirect()->route("liga.index")->withErrors(["error" => "Límite de jugadores superado"]);
        } else {
            $jugadores = Jugador::with("equipo_euro")->orderByDesc("val_media")->get();
            return view("cliente.equipo.add", [
                "jugadores" => $jugadores,
                "jornada" => $jornada_actual[0],
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
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $jornada = $request->jornada;
        $jugadores = $equipo->jugadores->where("pivot.jornada_id", $jornada)->sortByDesc("precio");
        return view("cliente.equipo.show", ["equipo" => $equipo, "jugadores" => $jugadores, "jornada" => $jornada, "jornadaObj" => $jornadaObj, "jornada_actual" => $jornada_actual[0]]);
    }

    public function attach(Request $request){
        $equipo = Equipo::find($request->equipo);
        $jugador = Jugador::find($request->jugador);
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $equipo->jugadores()->attach($jugador, ["jornada_id" => $jornada_actual[0]]);
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

    public function detach(Equipo $equipo, Jugador $jugador){
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $equipo->jugadores()->wherePivot("jornada_id", $jornada_actual[0])->detach($jugador);
//        DB::table("equipo_jornada_jugador")
//            ->where([
//                ['equipo_id', '=', $equipo->id],
//                ['jugador_id', '=', $jugador->id],
//                ['jornada_id', '=', $jornada_actual[0]]
//            ])
//            ->delete();

        return redirect()->route("equipo.show", [$equipo])->with('status', "¡Jugador $jugador->nombre vendido!");
    }
}
