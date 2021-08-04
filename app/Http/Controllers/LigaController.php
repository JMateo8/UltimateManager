<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLiga;
use App\Models\Equipo;
use App\Models\Jornada;
use App\Models\Liga;
use Illuminate\Http\Request;
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
        $user = auth()->user();
        $ligas = Liga::with("user")->get();
        $ligasAdmin = $user->ligas;
        $equipos = $user->equipos;
        $ligasActivas = Liga::with(["user"])
            ->whereHas('equipos', function($q) {
                $q->where('user_id', \auth()->id());
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
    public function store(StoreLiga $request)
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
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $equipos = $liga->equipos->sortByDesc("puntuacion");
        $ligasActivas = Liga::whereHas('equipos', function($q) {
            $q->where('user_id', auth()->id());
        })->pluck("id")->toArray();

        return view("cliente.liga.show", ["liga" => $liga, "equipos" => $equipos, "ligasActivas" => $ligasActivas, "jornada_actual" => $jornada_actual, "jornada" => "general"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function edit(Liga $liga)
    {
        $equipos = auth()->user()->equipos;
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
        $request->validate([
            'password' => 'required|min:8'
        ]);
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

    public function showJornada(Request $request, Liga $liga){
        $jornada_actual = Jornada::where("actual", 1)->first()->id;
        $jornada = $request->jornada;
        $equipos = $liga->equipos;
        $ligasActivas = Liga::whereHas('equipos', function($q) {
            $q->where('user_id', auth()->id());
        })->pluck("id")->toArray();
        return view("cliente.liga.show", ["liga" => $liga, "equipos" => $equipos, "ligasActivas" => $ligasActivas, "jornada" => $jornada, "jornada_actual" => $jornada_actual]);
    }
}
