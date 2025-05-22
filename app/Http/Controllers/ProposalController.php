<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{

    public function index($project)
    {
    // Encontrar o projeto pelo ID
    $project = Project::findOrFail($project);

    // Obter todas as propostas para esse projeto
    $proposals = $project->proposals;

    // Retornar a view com as propostas
    return view('proposals.index', compact('project', 'proposals'));
    }
    
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'message' => 'required|string',
            'price' => 'required|numeric',
            'deadline' => 'required|integer',
        ]);

        $proposal = new Proposal();
        $proposal->project_id = $projectId;
        $proposal->freelancer_id = Auth::id();
        $proposal->message = $request->message;
        $proposal->price = $request->price;
        $proposal->deadline = $request->deadline;
        $proposal->status = 'pendente';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposta enviada com sucesso!');
    }

    public function accept($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'aceita';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposta aceita!');
    }

    public function reject($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'rejeitada';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposta rejeitada.');
    }


    public function show($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('proposals.show', compact('proposal'));

    }

    public function update(Request $request, $id)
    {
        // Atualizar proposta
    }

    public function destroy($id)
    {
        // Deletar proposta
    }

    public function all()
{
    $proposals = Auth::user()->proposals()->with('project')->get(); //  carrega os projetos juntos
    return view('proposals.all', compact('proposals'));
}


}
