<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ProposalController extends Controller
{
    // Mostrar formulário de criação de proposta
    public function create(Project $project)
    {
        return view('freelancer.proposals.create', compact('project'));
    }

    public function index()
    {
        $proposals = Auth::user()->proposals()
                    ->with('project')
                    ->latest()
                    ->paginate(10);

        return view('freelancer.proposals.index', compact('proposals'));
    }

    // Armazenar nova proposta
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'deadline' => 'required|date|after:today',
            'budget' => 'required|numeric|min:0',
        ]);

        Proposal::create([
            'project_id' => $project->id,
            'freelancer_id' => Auth::id(),
            'message' => $validated['message'],
            'deadline' => Carbon::parse($validated['deadline']),
            'budget' => $validated['budget'],
            'status' => 'pending',
        ]);

        return redirect()->route('freelancer.dashboard')
           ->with('success', 'Proposta enviada com sucesso!');
    }
    public function destroy(Proposal $proposal)
        {
            // Verifica se a proposta pertence ao freelancer autenticado
            if ($proposal->freelancer_id !== Auth::id()) {
                abort(403, 'Acesso não autorizado');
            }

            $proposal->delete();

            return redirect()->route('freelancer.proposals.index')
                ->with('success', 'Proposta removida com sucesso!');
        }

        public function indexForClient()
        {
            $proposals = Proposal::whereHas('project', function($query) {
                    $query->where('client_id', Auth::id());
                })
                ->with(['project', 'freelancer' => function($query) {
                    $query->select('id', 'name', 'email'); // Garante que os campos necessários estão sendo carregados
                }])
                ->latest()
                ->paginate(10);

            return view('cliente.proposals.index', compact('proposals'));
        }

    public function showForClient(Proposal $proposal)
    {
        if ($proposal->project->client_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        return view('cliente.proposals.show', [
            'proposal' => $proposal->load(['project', 'freelancer']) 
        ]);
    }

    public function show($id)
    {
        // Lógica para mostrar uma proposta específica
        $proposal = Proposal::findOrFail($id);
        return view('freelancer.proposals.show', compact('proposal'));
    }

    public function accept(Proposal $proposal)
    {
        if ($proposal->project->client_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        DB::transaction(function () use ($proposal) {
            $proposal->update(['status' => 'accepted']);
            
            // Rejeitar todas as outras propostas para este projeto
            Proposal::where('project_id', $proposal->project_id)
                ->where('id', '!=', $proposal->id)
                ->update(['status' => 'rejected']);
                
            // Atualizar o status do projeto
            $proposal->project->update(['status' => 'in_progress']);
        });

        return back()->with('success', 'Proposta aceita com sucesso!');
    }

    public function reject(Proposal $proposal)
    {
        if ($proposal->project->client_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        $proposal->update(['status' => 'rejected']);

        return back()->with('success', 'Proposta rejeitada com sucesso!');
    }
    
}