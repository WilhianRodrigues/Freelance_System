<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;

class FreelancerPerfilController extends Controller
{
    public function edit()
    {
        $freelancer = Freelancer::where('user_id', Auth::id())->firstOrFail();
        return view('freelancer.perfil.edit', compact('freelancer'));
    }

    public function update(Request $request)
    {
        $freelancer = Freelancer::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'profession' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
            'portfolio_url' => 'nullable|url',
            'hourly_rate' => 'nullable|numeric',
        ]);

        $freelancer->update([
            'profession' => $request->profession,
            'bio' => $request->bio,
            'skills' => json_encode($request->skills),
            'portfolio_url' => $request->portfolio_url,
            'hourly_rate' => $request->hourly_rate,
        ]);

        return redirect()->route('freelancer.perfil.edit')->with('success', 'Perfil atualizado com sucesso!');
    }
    
    public function show()
    {
        $freelancer = \App\Models\Freelancer::where('user_id', Auth::id())->firstOrFail();
        return view('freelancer.perfil.show', compact('freelancer'));
    }

}
