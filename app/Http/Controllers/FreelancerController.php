<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    // Construtor para garantir que apenas usuários autenticados acessem as rotas
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibir o dashboard do freelancer
    public function index()
    {
        // Aqui podemos carregar dados específicos do freelancer, como projetos atribuídos
        $freelancer = Auth::user();
        
        return view('freelancer.dashboard', compact('freelancer'));
    }
    public function dashboard()
    {
        // Buscando todos os projetos disponíveis
        $projects = Project::where('status', 'disponivel')->get();

        return view('freelancer.dashboard', compact('projects'));
    }

    // Listar projetos disponíveis para o freelancer
    public function projetosDisponiveis()
    {
        $projetos = \App\Models\Project::where('status', 'aberto')->get();
        return view('freelancer.projetos', compact('projetos'));
    }

    public function editarPerfil()
    {
        $freelancer = Auth::user()->freelancer;
        return view('freelancer.perfil.edit', compact('freelancer'));
    }

    public function atualizarPerfil(Request $request)
    {
        $freelancer = Auth::user()->freelancer;
        $freelancer->update($request->only(['profession', 'bio', 'skills', 'portfolio_url', 'hourly_rate']));
        
        return redirect()->route('freelancer.dashboard')->with('success', 'Perfil atualizado com sucesso!');
    }

    // Enviar proposta para um projeto
    public function sendProposal(Request $request)
    {
        $request->validate([
            'projeto_id' => 'required|exists:projetos,id', // Verifica se o projeto existe
            'valor' => 'required|numeric',
            'prazo' => 'required|date',
            'mensagem' => 'nullable|string',
        ]);

        $projeto = Project::find($request->projeto_id);

        // Verificar se o freelancer já enviou proposta para esse projeto, ou realizar o envio
        // (Adapte a lógica conforme necessário)

        // Exemplo: Salvar proposta (se houver um modelo de Proposta)
        $proposta = $projeto->propostas()->create([
            'freelancer_id' => Auth::id(),
            'valor' => $request->valor,
            'prazo' => $request->prazo,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('freelancer.projects')->with('success', 'Proposta enviada com sucesso!');
    }
}
