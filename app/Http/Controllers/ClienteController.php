<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
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
        // Pega o ID do cliente logado
        $clienteId = \Illuminate\Support\Facades\Auth::user()->id;

        // Pega os projetos do cliente com suas propostas
        $propostas = \App\Models\Proposal::with('projeto', 'freelancer')
            ->whereHas('projeto', function ($query) use ($clienteId) {
                $query->where('cliente_id', $clienteId);
            })
            ->latest()
            ->get();

        return view('cliente.proposals.index', compact('propostas'));
    }

    public function editProfile()
    {
        return view('cliente.profile.edit', [
            'user' => \Illuminate\Support\Facades\Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('cliente.dashboard')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}
