<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!isset($_SESSION))
        {
            session_start();
        }

        if(!(session()->has('connexion') && session('connexion') == true))
        {
            return redirect()->route('index')->with('errorLogMiddleware', 'Identifiants incorrects');
        }
    


        return $next($request);
    }
}
