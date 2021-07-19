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

Route::group(["prefix" => "liga", "middleware" => ["auth"]], function (){
    Route::post("/inscribir", [\App\Http\Controllers\LigaController::class, 'inscribir'])
        ->name("inscribir");

    Route::post("/desapuntar", [\App\Http\Controllers\LigaController::class, 'desapuntar'])
        ->name("desapuntar");

    Route::post("/passvista", [\App\Http\Controllers\LigaController::class, 'passVista'])
        ->name("passvista");
});

Route::resource("liga", \App\Http\Controllers\LigaController::class)
    ->middleware("auth");

Route::group(["prefix" => "equipo", "middleware" => ["auth"]], function (){
    Route::post('/showJornada', [\App\Http\Controllers\EquipoController::class, 'showJornada'])
        ->name("showJornada");
    Route::post("/detach", [\App\Http\Controllers\EquipoController::class, 'detach'])
        ->name("detach");
    Route::post("/attach", [\App\Http\Controllers\EquipoController::class, 'attach'])
        ->name("attach");
});

Route::resource("equipo", \App\Http\Controllers\EquipoController::class)->middleware("auth");

Route::get('/mercado', function (){
    $jugadores = \App\Models\Jugador::orderByRaw("FIELD(posicion, 'Base', 'Escolta', 'Alero', 'Ala-Pivot', 'Pivot')")->get();
    return view('mercado', ["jugadores" => $jugadores]);
})->name("mercado");

require __DIR__.'/auth.php';
