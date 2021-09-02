<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrador
{
    public function handle($request, Closure $next)
    {
        if (Auth::User()->sesion == 'ADMIN') {
            return $next($request);
        }else{
            return abort(403);
        }
    }
}
