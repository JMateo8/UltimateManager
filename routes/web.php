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
    if (auth()->user()->admin === 1) {
        return view('admin.dashboard');
    } else {
        return view('dashboard');
    }
})->middleware(['auth'])->name('dashboard');

//Route::group(["prefix" => "user", "middleware" => ["auth"]], function (){
//    Route::post('/filtrarUser', [\App\Http\Controllers\UserController::class, 'filtrarUser'])
//        ->name("filtrarUser");
//});

Route::resource("user", \App\Http\Controllers\UserController::class)
    ->middleware("auth")->middleware("admin");

Route::group(["prefix" => "liga", "middleware" => ["auth"]], function (){
    Route::post("/inscribir", [\App\Http\Controllers\LigaController::class, 'inscribir'])
        ->name("inscribir");

    Route::post("/desapuntar", [\App\Http\Controllers\LigaController::class, 'desapuntar'])
        ->name("desapuntar");

    Route::post("/passvista", [\App\Http\Controllers\LigaController::class, 'passVista'])
        ->name("passvista");
    Route::post('/{liga}/showJornada', [\App\Http\Controllers\LigaController::class, 'showJornada'])
        ->name("showJornadaLiga");
});

Route::resource("liga", \App\Http\Controllers\LigaController::class)
    ->middleware("auth")
    ->missing(function () {
        return redirect()->route("liga.index");
    });

Route::group(["prefix" => "equipo", "middleware" => ["auth"]], function (){
    Route::post('/{equipo}/showJornada', [\App\Http\Controllers\EquipoController::class, 'showJornada'])
        ->name("showJornada");
    Route::post("/{equipo}/{jugador}/vender", [\App\Http\Controllers\EquipoController::class, 'vender'])
        ->name("vender");
    Route::post("/fichar", [\App\Http\Controllers\EquipoController::class, 'fichar'])
        ->name("fichar");
    Route::post('/{equipo}/anularCambios', [\App\Http\Controllers\EquipoController::class, 'anularCambios'])
        ->name("anularCambios");
});

Route::resource("equipo", \App\Http\Controllers\EquipoController::class)->middleware("auth")
    ->missing(function () {
        return redirect()->route("equipo.index");
    });

Route::resource("jugador", \App\Http\Controllers\JugadorController::class)
    ->middleware(["auth", "admin"]);

Route::get('/mercado', function (){
        $jugadores = \App\Models\Jugador::with("equipo_euro")->get();
        return view('mercado', ["jugadores" => $jugadores]);
    })->name("mercado")
    ->missing(function () {
        return back();
    });

Route::get('/faqs', function (){
        return view('faqs');
    })->name("faqs");

Route::post("/cerrarJornada", [\App\Http\Controllers\JornadaController::class, 'cerrarJornada'])
    ->name("cerrarJornada");

Route::post("/siguienteJornada", [\App\Http\Controllers\JornadaController::class, 'siguienteJornada'])
    ->name("siguienteJornada");

Route::post('file-import', [\App\Http\Controllers\JornadaJugadorController::class, 'fileImport'])->name('file-import');

require __DIR__.'/auth.php';
