<?php


use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    // Rota para o painel do freelancer
    Route::get('/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');
    
    // Outras rotas relacionadas ao freelancer
    Route::get('/projetos', [FreelancerController::class, 'projects'])->name('freelancer.projects');
    Route::post('/enviar-proposta', [FreelancerController::class, 'sendProposal'])->name('freelancer.sendProposal');

    // Rota para listar as propostas de um projeto específico
    Route::get('/projetos/{project}/propostas', [ProposalController::class, 'index'])->name('proposals.index');

    Route::get('/propostas', [ProposalController::class, 'all'])->name('proposals.all');


});