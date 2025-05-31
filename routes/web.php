<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    ClienteController,
    FreelancerController,
    ProjectController,
    ProposalController,
    FreelancerProfileController
};
use App\Http\Middleware\FreelancerMiddleware;
use App\Http\Middleware\ClienteMiddleware;

// Página inicial e autenticação
Route::get('/', fn () => view('welcome'))->name('welcome');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

require __DIR__.'/auth.php';
require __DIR__.'/geral.php';

// Grupo de rotas autenticadas
Route::middleware(['auth'])->group(function () {

    // Dashboards
    Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');
    Route::get('/freelancer/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');

    /**
     * ROTAS CLIENTE
     */
    Route::prefix('cliente')->middleware(ClienteMiddleware::class)->group(function () {
        // Projetos do cliente (resource)
        Route::resource('projects', ProjectController::class)
            ->names([
                'index' => 'cliente.projects.index',
                'create' => 'cliente.projects.create',
                'store' => 'cliente.projects.store',
                'show' => 'cliente.projects.show',
                'edit' => 'cliente.projects.edit',
                'update' => 'cliente.projects.update',
                'destroy' => 'cliente.projects.destroy'
            ]);

        // Propostas
        Route::prefix('proposals')->group(function () {
            Route::put('/{proposal}/accept', [ProposalController::class, 'accept'])->name('cliente.proposals.accept');
            Route::put('/{proposal}/reject', [ProposalController::class, 'reject'])->name('cliente.proposals.reject');
            Route::get('/cliente/propostas', [ClienteController::class, 'indexProposals'])
                ->name('cliente.proposals.index')
                ->middleware('auth');
        });
    });

    /**
     * ROTAS FREELANCER
     */
    Route::prefix('freelancer')->middleware(FreelancerMiddleware::class)->group(function() {
        // Dashboard
        Route::get('/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');
        
        // Projetos disponíveis
        Route::get('/projects', [FreelancerController::class, 'projects'])->name('freelancer.projects.index');
        Route::get('/projects/{project}', [FreelancerController::class, 'showProject'])->name('freelancer.projects.show');
        
        // Propostas
        Route::prefix('projects/{project}')->group(function() {
            Route::get('/propose', [ProposalController::class, 'create'])->name('freelancer.proposals.create');
            Route::post('/proposals', [ProposalController::class, 'store'])->name('freelancer.proposals.store');
        });
        
        // Lista de propostas do freelancer
        Route::resource('proposals', ProposalController::class)
            ->only(['index', 'show', 'destroy'])
            ->names([
                'index' => 'freelancer.proposals.index',
                'show' => 'freelancer.proposals.show',
                'destroy' => 'freelancer.proposals.destroy'
        ]);
        // Perfil
        Route::prefix('profile')->group(function () {
            Route::get('/', [FreelancerProfileController::class, 'show'])->name('freelancer.profile.show');
            Route::get('/edit', [FreelancerProfileController::class, 'edit'])->name('freelancer.profile.edit');
            Route::put('/', [FreelancerProfileController::class, 'update'])->name('freelancer.profile.update');
        });
    });
});