<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'content' => 'required|string|max:2000',
        ]);

        // Verifica se o usuário tem permissão para enviar mensagens neste projeto
        $project = Project::findOrFail($request->project_id);
        $freelancer = Auth::user()->freelancer;

        if (!$project->acceptedProposal || $project->acceptedProposal->freelancer_id != $freelancer->id) {
            abort(403, 'Acesso não autorizado');
        }

        Message::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }
}
