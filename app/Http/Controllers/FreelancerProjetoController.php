<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Freelancer;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class FreelancerProjetoController extends Controller
{
    public function index()
    {
        $projetos = Project::where('status', 'open')->get();
        return view('freelancer.projetos.index', compact('projetos'));
    }

    public function show($id)
    {
        $projeto = Project::findOrFail($id);
        return view('freelancer.projetos.show', compact('projeto'));
    }

    public function enviarProposta(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'deadline' => 'required|integer',
            'message' => 'required|string',
        ]);

        $freelancer = Freelancer::where('user_id', Auth::id())->first();

        Proposal::create([
            'project_id' => $id,
            'freelancer_id' => $freelancer->id,
            'price' => $request->price,
            'deadline' => $request->deadline,
            'message' => $request->message,
        ]);

        return redirect()->route('freelancer.projetos.index')->with('success', 'Proposta enviada com sucesso!');
    }
}
