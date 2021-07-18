<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    //
    public function index(){
        $users = \App\Models\User::all();
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

        $user = new \App\Models\User($request->input());
        $user->save();

        return redirect()->route("user.index")->with('status', "¡Usuario $user->name creado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\User $user)
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
    public function update(Request $request, \App\Models\User $user)
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

    public function destroy(\App\Models\User $user){
        $user->delete();
        return redirect()->route("user.index")->with('status', "¡Usuario $user->name eliminado!");
    }


}
