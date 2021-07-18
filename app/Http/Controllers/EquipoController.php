<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jornada;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipos = User::find(Auth::id())->equipos;
        return view("cliente.equipo.listado", ["equipos" => $equipos]);
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
        return redirect()->route("equipo.index")->with('status', "¡Equipo $equipo->nombre creado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {
        $jornada_actual = Jornada::where("actual", 1)->pluck("id");
        $jugadoresPivot = $equipo->jugadores;
        $jugadores = [];
        foreach ($jugadoresPivot as $jugador){
            if ($jugador->pivot["jornada_id"] === $jornada_actual[0]){
                $jugadores[] = $jugador;
            }
        }
        return view("cliente.equipo.show", ["equipo" => $equipo, "jugadores" => $jugadores, "jornada_actual" => $jornada_actual[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipo $equipo)
    {
        //
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

    public function showJornada(Request $request, Equipo $equipo){
        $jornada = $request->jornada;
        echo $jornada;
        $jugadoresPivot = $equipo->jugadores;
        $jugadores = [];
        foreach ($jugadoresPivot as $jugador){
            if ($jugador->pivot["jornada_id"] === $jornada){
                $jugadores[] = $jugador;
            }
        }
        return view("cliente.equipo.show", ["equipo" => $equipo, "jugadores" => $jugadores, "jornada" => $jornada]);
    }
}
