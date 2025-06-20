<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $user = Auth::user();
        $freelancer = $user->freelancer;
        
        // Carrega contagens para o dashboard
        $user->loadCount([
            'proposals as active_proposals_count' => function($query) {
                $query->where('status', 'active');
            },
            'proposals as completed_proposals_count' => function($query) {
                $query->where('status', 'completed');
            }
        ]);

        // Projetos disponíveis
        $availableProjects = Project::where('status', 'open')
            ->whereDoesntHave('proposals', function($query) use ($freelancer) {
                $query->where('freelancer_id', $freelancer->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('freelancer.dashboard', [
            'activeProposalsCount' => $user->active_proposals_count,
            'completedProjectsCount' => $user->completed_proposals_count,
            'availableProjects' => $availableProjects
        ]);
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
        // Verifica se o freelancer tem proposta aceita para este projeto
        if (!$project->acceptedProposal || $project->acceptedProposal->freelancer_id != Auth::user()->freelancer->id) {
            abort(403, 'Acesso não autorizado');
        }

        return view('freelancer.projects.show', [
            'project' => $project,
            'proposal' => $project->acceptedProposal
        ]);
    }

    /**
     * Mostrar mensagens do projeto
     */
    public function showMessages(Project $project)
    {
        // Verifica se o freelancer tem proposta aceita para este projeto
        $freelancer = Auth::user()->freelancer;
        
        if (!$project->acceptedProposal || $project->acceptedProposal->freelancer_id != $freelancer->id) {
            abort(403, 'Acesso não autorizado');
        }

        return view('freelancer.projects.messages', [
            'project' => $project,
            'messages' => $project->messages()->with('user')->latest()->get()
        ]);
    }

    /**
     * Mostrar perfil do freelancer
     */
    public function show()
    {
        $user = Auth::user();
        return view('freelancer.profile.show', compact('user'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $user->load('freelancer');
        
        return view('freelancer.profile.show', compact('user'));
    }

    /**
     * Mostrar formulário de edição de perfil
     */
    public function editProfile()
    {
        $user = Auth::user();
        $freelancer = $user->freelancer; // Assumindo que há um relacionamento entre User e Freelancer
        
        return view('freelancer.profile.edit', [
            'user' => $user,
            'freelancer' => $freelancer
        ]);
    }
    /**
     * Atualizar perfil do freelancer
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $freelancer = $user->freelancer;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profession' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'portfolio_url' => 'nullable|url|max:255'
        ]);

        try {
            // Atualiza os dados do usuário
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);

            // Atualiza os dados do freelancer
            if ($freelancer) {
                $freelancer->update([
                    'profession' => $validated['profession'],
                    'skills' => $validated['skills'],
                    'bio' => $validated['bio'],
                    'hourly_rate' => $validated['hourly_rate'],
                    'portfolio_url' => $validated['portfolio_url']
                ]);
            } else {
                // Cria o registro de freelancer se não existir
                Freelancer::create([
                    'user_id' => $user->id,
                    'profession' => $validated['profession'],
                    'skills' => json_encode($validated['skills']),
                    'bio' => $validated['bio'],
                    'hourly_rate' => $validated['hourly_rate'],
                    'portfolio_url' => $validated['portfolio_url']
                ]);
            }

            return redirect()->route('freelancer.profile.show')
                ->with('success', 'Perfil atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar perfil. Tente novamente.');
        }
    }

    /**
     * Listar propostas do freelancer
     */
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