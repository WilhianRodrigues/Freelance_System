<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
   public function createFreelancerRating(Project $project)
{
    // Verificar se o projeto pertence ao cliente
    if ($project->client_id != Auth::id()) {
        abort(403);
    }

    return view('cliente.ratings.create', [
        'project' => $project,
        'user' => $project->freelancer,
        'type' => 'client_to_freelancer'
    ]);
}

public function storeFreelancerRating(Request $request, Project $project)
{
    $request->validate([
        'score' => 'required|integer|between:1,5',
        'comment' => 'nullable|string|max:500'
    ]);

    Rating::create([
        'project_id' => $project->id,
        'rater_id' => Auth::id(),
        'rated_id' => $project->freelancer_id,
        'score' => $request->score,
        'comment' => $request->comment,
        'type' => 'client_to_freelancer'
    ]);

    return redirect()->route('cliente.projects.show', $project)
        ->with('success', 'Avaliação enviada com sucesso!');
}
}
