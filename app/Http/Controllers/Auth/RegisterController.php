<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Freelancer;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:cliente,freelancer'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'client', 
        ]);

        if ($data['role'] === 'cliente') {
            Client::create([
                'user_id' => $user->id,
                'registration_date' => now(),
            ]);
        } else {
            Freelancer::create([
                'user_id' => $user->id,
                'registration_date' => now(),
            ]);
        }

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        // Faz logout para encerrar qualquer sessão iniciada automaticamente
        Auth::logout();
        
        // Redireciona para login com mensagem de sucesso
        return redirect()->route('login')
            ->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }
}