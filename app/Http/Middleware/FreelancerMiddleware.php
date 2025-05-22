<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FreelancerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'freelancer') {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
    
}
