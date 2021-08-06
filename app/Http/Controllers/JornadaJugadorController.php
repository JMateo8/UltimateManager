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
        $filename = $request->file->getClientOriginalName();
        if (preg_match("/.xlsx$/", $filename)) {
            try {
                Excel::import(new JornadaJugadorImport, $request->file('file')->store('temp'));
            } catch (\InvalidArgumentException $ex) {
                return redirect()->back()->withErrors(["error" => '¡Algún dato de las columnas es inválido!']);
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(["error" => '¡Error en el archivo ' . $request->file->getClientOriginalName() . "!"]);
            } catch (\Error $ex) {
                return redirect()->back()->withErrors(["error" => $ex->getMessage()]);
            }
        } else {
            return redirect()->back()->withErrors(["error" => "Tipo de archivo no deseado"]);
        }
        return redirect()->back()->with('status', '¡Jornada actualizada correctamente!');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new JornadaJugadorExport, 'jornada-jugador.xlsx');
    }
}
