<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FreelancerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\FreelancerMiddleware::class);
    }

    /**
     * Exibir o dashboard do freelancer
     */
    public function index()
    {
        $freelancer = Auth::user()->freelancer;
        
        // Estatísticas
        $projectsInProgress = Proposal::where('freelancer_id', $freelancer->id)
            ->where('status', 'in_progress')
            ->count();
        
        $completedProjects = Proposal::where('freelancer_id', $freelancer->id)
            ->where('status', 'completed')
            ->count();
        
        $totalProposals = $freelancer->proposals()->count();
        
        // Projetos disponíveis
        $availableProjects = Project::where('status', 'open')
            ->whereDoesntHave('proposals', function($query) use ($freelancer) {
                $query->where('freelancer_id', $freelancer->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('freelancer.dashboard', compact(
            'projectsInProgress',
            'completedProjects',
            'totalProposals',
            'availableProjects'
        ));
    }

    /**
     * Listar projetos disponíveis
     */
    public function projects()
    {
        $freelancer = Auth::user()->freelancer;
        
        $projects = Project::where('status', 'open')
            ->whereDoesntHave('proposals', function($query) use ($freelancer) {
                $query->where('freelancer_id', $freelancer->id);
            })
            ->paginate(10);

        return view('freelancer.projects.index', compact('projects'));
    }

    /**
     * Mostrar detalhes de um projeto
     */
    public function showProject(Project $project)
    {
        return view('freelancer.projects.show', compact('project'));
    }

    /**
     * Mostrar formulário de edição de perfil
     */
    public function editProfile()
    {
        $freelancer = Auth::user()->freelancer;
        return view('freelancer.profile.edit', [
            'freelancer' => $freelancer,
            'skills' => json_decode($freelancer->skills, true) ?? []
        ]);
    }

    /**
     * Atualizar perfil do freelancer
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'profession' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
            'portfolio_url' => 'nullable|url',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $freelancer = Auth::user()->freelancer;
        $freelancer->update([
            'profession' => $validated['profession'],
            'bio' => $validated['bio'],
            'skills' => json_encode($validated['skills']),
            'portfolio_url' => $validated['portfolio_url'],
            'hourly_rate' => $validated['hourly_rate'],
        ]);
        
        return redirect()->route('freelancer.dashboard')
               ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function proposals()
    {
        $proposals = Auth::user()->proposals()
                    ->with('project')
                    ->latest()
                    ->paginate(10);

        return view('freelancer.proposals.index', compact('proposals'));
    }


    /**
     * Enviar proposta para um projeto
     */
    public function sendProposal(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'value' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'message' => 'nullable|string|max:1000',
        ]);

        $freelancer = Auth::user()->freelancer;
        
        // Verifica se já existe proposta para este projeto
        $existingProposal = Proposal::where('project_id', $validated['project_id'])
            ->where('freelancer_id', $freelancer->id)
            ->first();

        if ($existingProposal) {
            return back()->with('error', 'Você já enviou uma proposta para este projeto.');
        }

        // Cria a nova proposta
        Proposal::create([
            'project_id' => $validated['project_id'],
            'freelancer_id' => $freelancer->id,
            'value' => $validated['value'],
            'deadline' => $validated['deadline'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('freelancer.projects.index')
               ->with('success', 'Proposta enviada com sucesso!');
    }
}