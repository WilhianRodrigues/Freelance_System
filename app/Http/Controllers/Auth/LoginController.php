<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirecionamento baseado no role do usuário
            return $this->authenticated($request, $user);
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // Mensagem traduzida
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // Verifica se o usuário está ativo ou outros pré-requisitos
        // if (!$user->is_active) {
        //     Auth::logout();
        //     return redirect('/login')->with('error', 'Sua conta está desativada');
        // }

        switch ($user->role) {
            case 'cliente':
                return redirect()->intended('/cliente/dashboard')
                    ->with('success', 'Login realizado com sucesso!');
            case 'freelancer':
                return redirect()->intended('/freelancer/dashboard')
                    ->with('success', 'Login realizado com sucesso!');
            default:
                return redirect()->intended('/dashboard')
                    ->with('success', 'Login realizado com sucesso!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Você saiu do sistema.');
    }
}