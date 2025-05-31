<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    
}