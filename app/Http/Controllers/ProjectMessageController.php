<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewProjectMessage;

class ProjectMessageController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'content' => 'required|string|max:2000'
        ]);

        $recipient = ($project->client_id === Auth::id()) 
            ? $project->acceptedProposal->freelancer 
            : $project->client;

        $recipient->notify(new NewProjectMessage($project));

        // Verificar se o usuário tem permissão para enviar mensagens neste projeto
        if (!$this->checkProjectAccess($project)) {
            abort(403, 'Acesso não autorizado');
        }

        $project->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }

    protected function checkProjectAccess(Project $project)
    {
        // Cliente pode enviar mensagens em seus projetos
        if (Auth::user()->role === 'cliente' && $project->client_id === Auth::id()) {
            return true;
        }

        // Freelancer pode enviar mensagens em projetos onde sua proposta foi aceita
        if (Auth::user()->role === 'freelancer' && 
            $project->acceptedProposal && 
            $project->acceptedProposal->freelancer_id === Auth::id()) {
            return true;
        }

        return false;
    }
}
