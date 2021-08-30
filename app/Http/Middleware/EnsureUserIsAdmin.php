<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!(auth()->user()->admin)){ //Si el usuario no es aministrador devuelve con mensaje de error
            return redirect()->back()->withErrors(["error" => "Error. Acceso denegado"]);
        }
        return $next($request); //Si es administrador, se acepta la petición
    }
}
