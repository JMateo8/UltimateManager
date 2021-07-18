<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route("dashboard");
});

Route::get('/dashboard', function () {
    $users = \App\Models\User::all();
    if (Auth::user()->admin === 1) {
        return view('admin.dashboard', ["users" => $users]);
    } else {
        return view('dashboard', ["users" => $users]);
    }
})->middleware(['auth'])->name('dashboard');

Route::resource("user", \App\Http\Controllers\User::class)
    ->middleware("auth")->middleware("admin");

Route::get('/mercado', function (){
    $jugadores = \App\Models\Jugador::orderByRaw("FIELD(posicion, 'Base', 'Escolta', 'Alero', 'Ala-Pivot', 'Pivot')")->get();
    return view('mercado', ["jugadores" => $jugadores]);
});

Route::post('equipo/showJornada', [\App\Http\Controllers\EquipoController::class, 'showJornada'])->middleware("auth")
    ->name("showJornada");

Route::resource("equipo", \App\Http\Controllers\EquipoController::class)->middleware("auth");

require __DIR__.'/auth.php';
