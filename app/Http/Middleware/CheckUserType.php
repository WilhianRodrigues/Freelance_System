<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $type)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || $user->type != $type) {
            return redirect('/'); // Ou uma página de não autorizado
        }
        
        return $next($request);
    }
}
