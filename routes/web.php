<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    ClienteController,
    FreelancerController,
    ClienteProjetoController,
    ProjectController,
    ProposalController,
    FreelancerProjetoController,
    FreelancerPerfilController
};
use App\Http\Middleware\FreelancerMiddleware;
use App\Http\Middleware\ClienteMiddleware;

// Página inicial e autenticação
Route::get('/welcome', fn () => view('welcome'))->name('welcome');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

require __DIR__.'/auth.php';
require __DIR__.'/geral.php';

// Grupo de rotas autenticadas
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');
    Route::get('/freelancer/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');

    // Redirecionamentos simples
    Route::get('/cliente', fn () => view('cliente.dashboard'));
    Route::get('/freelancer', fn () => view('freelancer.dashboard'));

    /**
     * ROTAS CLIENTE
     */
    Route::prefix('cliente')->middleware(ClienteMiddleware::class)->group(function () {
        Route::resource('projetos', ClienteProjetoController::class)->names('cliente.projetos');

        // Gerenciamento de propostas recebidas
        Route::put('/proposals/{proposal}/accept', [ProposalController::class, 'accept'])->name('proposals.accept');
        Route::put('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');

        // Projetos (versão geral se usada por ambos)
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    /**
     * ROTAS FREELANCER
     */
    Route::prefix('freelancer')->middleware(FreelancerMiddleware::class)->group(function () {
        // Projetos disponíveis
        Route::get('projetos', [FreelancerProjetoController::class, 'index'])->name('freelancer.projetos.index');
        Route::get('projetos/{id}', [FreelancerProjetoController::class, 'show'])->name('freelancer.projetos.show');
        Route::post('projetos/{id}/proposta', [FreelancerProjetoController::class, 'enviarProposta'])->name('freelancer.projetos.enviarProposta');

        // Perfil
        Route::get('/perfil', [FreelancerPerfilController::class, 'show'])->name('freelancer.perfil.show');
        Route::get('/perfil/editar', [FreelancerPerfilController::class, 'edit'])->name('freelancer.perfil.edit');
        Route::post('/perfil', [FreelancerPerfilController::class, 'update'])->name('freelancer.perfil.update');

        // Propostas
        Route::get('/projects', [FreelancerController::class, 'projects'])->name('freelancer.projects');
        Route::post('/projects/{project}/proposals', [ProposalController::class, 'store'])->name('proposals.store');
        Route::get('/proposals', [ProposalController::class, 'all'])->name('proposals.all');
        Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
        Route::get('/proposals/create/{project}', [ProposalController::class, 'create'])->name('proposals.create');
    });
});
