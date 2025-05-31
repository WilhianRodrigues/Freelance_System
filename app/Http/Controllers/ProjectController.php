<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('proposals')
                    ->where('client_id', Auth::id())
                    ->latest()
                    ->get();
                    
        return view('cliente.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('cliente.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'budget' => 'required|numeric|min:0',
        ]);

        Project::create([
            'client_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'budget' => $validated['budget'],
            'status' => 'open'
        ]);

        return redirect()->route('cliente.projects.index')
               ->with('success', 'Projeto criado com sucesso!');
    }

    public function show(Project $project)
    {
        
        if (Auth::id() !== $project->client_id) {
            abort(403, 'Acesso não autorizado.');
        }
    
    return view('cliente.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        if (Auth::id() !== $project->client_id) {
            abort(403, 'This action is unauthorized.');
        }
        
        return view('cliente.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // Verifica se o usuário é o dono do projeto
        if (Auth::id() !== $project->client_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'budget' => 'required|numeric|min:0',
        ]);

        $project->update($validated);

        return redirect()->route('cliente.projects.index')
               ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Project $project)
    {
        
        if (Auth::id() !== $project->client_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $project->delete();

        return redirect()->route('cliente.projects.index')
           ->with('success', 'Projeto excluído com sucesso!');
    }
}