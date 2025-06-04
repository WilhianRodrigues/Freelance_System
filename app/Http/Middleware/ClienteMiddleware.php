<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verifique o campo que armazena o tipo de usuário
        if ($user->role === 'cliente') {
            return $next($request);
        }

        // Debug adicional
        logger()->error('Tentativa de acesso de não-cliente', [
            'user_id' => $user->id,
            'user_type' => $user->role
        ]);

        abort(403, 'Acesso permitido apenas para clientes');
    }
}