<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FreelancerProfileController extends Controller
{
    /**
     * Mostra o perfil do freelancer
     */
    public function show($id)
    {
        $user = User::with(['freelancer', 'ratingsReceived'])->findOrFail($id);

        // Verifica se o usuário é realmente um freelancer
        if (!$user->freelancer) {
            abort(404, 'Freelancer não encontrado.');
        }

        return view('freelancer.profile.public', compact('user'));
    }

    /**
     * Exibe o formulário de edição do perfil
     */
    public function edit()
    {
        $freelancer = Freelancer::where('user_id', Auth::id())
                      ->firstOrFail();
        
        return view('freelancer.profile.edit', [
            'freelancer' => $freelancer,
            'skills' => json_decode($freelancer->skills) // Decodifica as skills para o formulário
        ]);
    }

    /**
     * Atualiza o perfil do freelancer
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'profession' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
            'portfolio_url' => 'nullable|url',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $freelancer = Freelancer::where('user_id', Auth::id())->firstOrFail();
        
        $freelancer->update([
            'profession' => $validated['profession'],
            'bio' => $validated['bio'],
            'skills' => json_encode($validated['skills']),
            'portfolio_url' => $validated['portfolio_url'],
            'hourly_rate' => $validated['hourly_rate'],
        ]);

        return redirect()->route('freelancer.profile.show')
               ->with('success', 'Perfil atualizado com sucesso!');
    }
}