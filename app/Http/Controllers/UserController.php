<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('admin.user.listado', ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.user.create");
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

        $user = new User($request->input());
        $user->save();

        return redirect()->route("user.index")->with('status', "¡Usuario $user->name creado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("admin.user.edit", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->merge([
            'password' => Hash::make($request->password)
        ]);

        $user->fill($request->input())->saveOrFail();

        return redirect()->route("user.index")->with('status', "¡Usuario $user->name actualizado!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user){
        $user->delete();
        return redirect()->route("user.index")->with('status', "¡Usuario $user->name eliminado!");
    }

//    public function filtrarUser(Request $request){
//        $users = User::all();
//        $usersFiltro = User::where("name", $request->name)->get();
//        return view('admin.user.listado', ["users" => $users, "usersFiltro" => $usersFiltro]);
//    }

}
