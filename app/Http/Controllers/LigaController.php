<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Liga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LigaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $user = \App\Models\User::find($userId);
        $ligas = Liga::all();
        $ligasAdmin = $user->ligas;
        $equipos = $user->equipos;
        $ligasActivas = Liga::whereHas('equipos', function($q) use($userId) {
            $q->where('user_id', $userId);
        })->get();
        /*
        $ligasLibres = Liga::whereDoesntHave('equipos', function($q) use($userId) {
            $q->where('user_id', $userId);
        })->get();
        */
        return view("cliente.liga.listado",
                ["ligas" => $ligas,
                "ligasAdmin" => $ligasAdmin,
                "ligasActivas" => $ligasActivas,
                "equipos" => $equipos]);
    }

    public function data(){
        $ligas = Liga::join('equipo_liga', 'ligas.id', '=', 'equipo_liga.liga_id')
            ->join('equipos', 'equipo_liga.equipo_id', '=', 'equipos.id')
            ->where('equipos.id_user', Auth::user()->id)
            ->get(['ligas.id', 'ligas.nom_liga', 'equipos.nom_eq_fnt', 'ligas.admin']);
        return $ligas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cliente.liga.create");
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
            'password' => Hash::make($request->password)
        ]);
        $liga = new Liga($request->input());
        $liga->save();

        return redirect()->route("liga.index")->with('status', "¡Nueva liga $liga->nombre añadida!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function show(Liga $liga)
    {
        $equipos = $liga->equipos->sortByDesc("puntuacion");

        return view("cliente.liga.show", ["liga" => $liga, "equipos" => $equipos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function edit(Liga $liga)
    {
        $equipos = \App\Models\User::find(Auth::id())->equipos;
        $nEq = $equipos->count();
        if ($nEq !== 0) {
            return view("cliente.liga.add", ["liga" => $liga, "equipos" => $equipos]);
        } else {
            return redirect()->route("liga.index")->withErrors(["error" => "Error. No tienes ningún equipo creado"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liga $liga)
    {
        $request->merge([
            'password' => Hash::make($request->password)
        ]);

        $liga->fill($request->input())->saveOrFail();

        return redirect()->route("liga.index")->with('status', "¡Contraseña actualizada ($liga->nombre)!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liga $liga)
    {
        $liga->delete();
        return redirect()->route("liga.index")->with('status', "¡Liga $liga->nombre eliminada!");
    }

    public function inscribir(Request $request) {
        $liga = Liga::find($request->liga);
        if (Hash::check($request->password, $liga->password) && !is_null($request->equipo)) {
            $equipo = Equipo::find($request->equipo);
            $liga->equipos()->attach($equipo);
            return redirect()->route("liga.show", [$liga])->with('status', "¡Equipo $equipo->nombre inscrito!");
        } else {
            return redirect()->route("liga.index")->withErrors(["error" => "Error. Contraseña incorrecta"]);
        }
    }

    public function desapuntar(Request $request) {
        $liga = Liga::find($request->liga);
        $equipo = Equipo::find($request->equipo);
        $liga->equipos()->detach($equipo);
        return redirect()->route("liga.show", [$liga])->with('status', "¡Equipo $equipo->nombre desapuntado!");
    }

    public function passVista(Request $request) {
        $liga = Liga::find($request->liga);
        return view("cliente.liga.pass", ['liga' => $liga]);
    }
}
