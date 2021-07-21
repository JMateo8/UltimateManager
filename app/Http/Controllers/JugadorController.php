<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jugadores = \App\Models\Jugador::with("equipo_euro")->get();
        //info($jugadores);
        return view("admin.jugador.listado", ["jugadores" => $jugadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.jugador.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'nombre' => $request->apellido . ", " . $request->nombre
        ]);
        $request->request->remove('apellido');
        $jugador = new Jugador($request->input());
        $jugador->save();
        return redirect()->route("jugador.index")->with('status', "¡Jugador $jugador->nombre creado!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jugador  $jugador
     * @return \Illuminate\Http\Response
     */
    public function show(Jugador $jugador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jugador  $jugador
     * @return \Illuminate\Http\Response
     */
    public function edit(Jugador $jugador)
    {
        list($apellido, $nombre) = explode(", ", $jugador->nombre);
        return view("admin.jugador.edit", ["jugador" =>$jugador, "apellido" => $apellido, "nombre" => $nombre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jugador  $jugador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jugador $jugador)
    {
        $request->merge([
            'nombre' => $request->apellido . ", " . $request->nombre
        ]);
        $request->request->remove('apellido');
        $jugador->fill($request->input())->saveOrFail();
        return redirect()->route("jugador.index")->with('status', "¡Jugador $jugador->nombre actualizado!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jugador  $jugador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jugador $jugador)
    {
        $jugador->delete();
        return redirect()->route("jugador.index")->with('status', "¡Jugador $jugador->nombre eliminado!");
    }
}
