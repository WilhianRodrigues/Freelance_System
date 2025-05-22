<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ClienteProjetoController extends Controller
{
    public function index()
    {
        $projetos = Project::where('client_id', Auth::id())->get();
        return view('cliente.projetos.index', compact('projetos'));
    }

    public function create()
    {
        return view('cliente.projetos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'budget' => 'required|decimal(10,2)',
        ]);

        Project::create([
            'client_id' => Auth::id(),
            'title' => $request->titulo,
            'description' => $request->descricao,
            'deadline' => $request->prazo,
            'budget' => $request->orcamento,
            'status' => 'aberto'
        ]);

        return redirect()->route('cliente.projetos.index')->with('success', 'Projeto criado com sucesso!');
    }

    public function edit($id)
    {
        $projeto = Project::where('id', $id)->where('client_id', Auth::id())->firstOrFail();
        return view('cliente.projetos.edit', compact('projeto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'budget' => 'required|decimal(10,2)',
        ]);

        $projeto = Project::where('id', $id)->where('client_id', Auth::id())->firstOrFail();
        $projeto->update($request->only(['title', 'description', 'price', 'budget']));

        return redirect()->route('cliente.projetos.index')->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $projeto = Project::where('id', $id)->where('client_id', Auth::id())->firstOrFail();
        $projeto->delete();

        return redirect()->route('cliente.projetos.index')->with('success', 'Projeto deletado com sucesso!');
    }
}

