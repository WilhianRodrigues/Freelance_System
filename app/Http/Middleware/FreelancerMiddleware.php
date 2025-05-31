<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerMiddleware
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
        // Verifica se o usuário está autenticado e é um freelancer
        if (Auth::check() && Auth::user()->role === 'freelancer') {
            return $next($request);
        }

        // Redireciona usuários não autorizados
        return redirect('/')->with('error', 'Acesso não autorizado para freelancers');
    }
}