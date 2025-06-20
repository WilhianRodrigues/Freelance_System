<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('cliente.dashboard', [
            'activeProjectsCount' => Project::where('client_id', $user->id)
                                        ->where('status', 'open')
                                        ->count(),
            'proposalsCount' => Proposal::whereIn('project_id', 
                Project::where('client_id', $user->id)->pluck('id')
            )->count(),
            'recentProjects' => Project::withCount('proposals')
                                    ->where('client_id', $user->id)
                                    ->latest()
                                    ->take(5)
                                    ->get()
        ]);
    }

    public function propostasRecebidas()
    {
        $clienteId = Auth::user()->id;

        $propostas = Proposal::with('projeto', 'freelancer')
            ->whereHas('projeto', function ($query) use ($clienteId) {
                $query->where('cliente_id', $clienteId);
            })
            ->latest()
            ->get();

        return view('cliente.proposals.index', compact('propostas'));
    }

    public function editProfile()
    {
        $user = Auth::user()->load('client');
        
        return view('cliente.profile.edit', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            // Atualiza os dados do usuário
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email']
            ];
            
            // Atualiza a senha apenas se foi fornecida
            if (!empty($validated['password'])) {
                $userData['password'] = bcrypt($validated['password']);
            }
            
            $user->update($userData);

            // Atualiza ou cria os dados do cliente
            $clientData = [
                'company_name' => $validated['company_name'],
                'phone' => $validated['phone']
            ];
            
            if ($user->client) {
                $user->client->update($clientData);
            } else {
                $clientData['user_id'] = $user->id;
                Client::create($clientData);
            }

            return redirect()->route('cliente.profile.show')
                ->with('success', 'Perfil atualizado com sucesso!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }

    public function showProfile()
    {
        $user = Auth::user()->load('client');
        
        return view('cliente.profile.show', [
            'user' => $user,
            'activeProjectsCount' => Project::where('client_id', $user->id)
                                        ->where('status', 'open')
                                        ->count(),
            'proposalsCount' => Proposal::whereIn('project_id', 
                Project::where('client_id', $user->id)->pluck('id')
            )->count(),
            'recentProjects' => Project::withCount('proposals')
                                    ->where('client_id', $user->id)
                                    ->latest()
                                    ->take(3)
                                    ->get()
        ]);
    }
}