<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session('auth')){
            if(session('rolUserData')[0]->descripcion_corta == 'R22'){
                return redirect('/dashboard');
            }if(session('rolUserData')[0]->descripcion_corta == 'R23'){
                return redirect('/report');
            }
        }
        return $next($request);
    }
}
