<?php

namespace App\Http\Controllers;

use App\Exports\JornadaJugadorExport;
use App\Imports\JornadaJugadorImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JornadaJugadorController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImportExport()
    {
        return view('file-import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
        Excel::import(new JornadaJugadorImport, $request->file('file')->store('temp'));
        return back();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new JornadaJugadorExport, 'jornada-jugador.xlsx');
    }
}
