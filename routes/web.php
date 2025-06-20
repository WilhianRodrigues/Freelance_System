<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    ClienteController,
    FreelancerController,
    ProjectController,
    ProposalController,
    ProjectMessageController,
    MessageController
};
use App\Http\Controllers\RatingController;
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
    Route::middleware(['auth', ClienteMiddleware::class])->group(function () {

        // Rotas de avaliação para cliente
        Route::get('/projects/{project}/rate-freelancer', [RatingController::class, 'createFreelancerRating'])
            ->name('cliente.ratings.create_freelancer');
        Route::post('/projects/{project}/rate-freelancer', [RatingController::class, 'storeFreelancerRating'])
            ->name('cliente.ratings.store_freelancer');
        Route::get('/profile/edit', [ClienteController::class, 'editProfile'])->name('cliente.profile.edit');
        Route::put('/profile/update', [ClienteController::class, 'updateProfile'])->name('cliente.profile.update');
        Route::get('/cliente/profile', [ClienteController::class, 'showProfile'])
            ->name('cliente.profile.show');

        // Projetos do cliente (resource)
        Route::resource('cliente/projects', ProjectController::class)
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
        Route::prefix('cliente')->group(function () {
            Route::get('/proposals', [ProposalController::class, 'indexForClient'])
                ->name('cliente.proposals.index');
            Route::get('/proposals/{proposal}', [ProposalController::class, 'showForClient'])
                ->name('cliente.proposals.show');
            Route::put('/proposals/{proposal}/accept', [ProposalController::class, 'accept'])
                ->name('cliente.proposals.accept');
            Route::put('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])
                ->name('cliente.proposals.reject');
        });
    });

    /**
     * ROTAS FREELANCER
     */
    Route::prefix('freelancer')->middleware(FreelancerMiddleware::class)->group(function() {

        // Rotas de avaliação para freelancer
        Route::get('/projects/{project}/rate-client', [RatingController::class, 'createClientRating'])
            ->name('freelancer.ratings.create_client');
        Route::post('/projects/{project}/rate-client', [RatingController::class, 'storeClientRating'])
            ->name('freelancer.ratings.store_client');

        // Dashboard
        Route::get('/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');
        
        // Projetos disponíveis
        Route::get('/projects', [FreelancerController::class, 'projects'])->name('freelancer.projects.index');
        Route::get('/projects/{project}', [FreelancerController::class, 'showProject'])->name('freelancer.projects.show');
        Route::get('/projects/{project}/messages', [FreelancerController::class, 'showMessages'])
            ->name('freelancer.projects.messages');
        Route::post('/projects/{project}/messages', [ProjectMessageController::class, 'store'])
            ->name('projects.messages.store');
        Route::post('/messages', [ProjectMessageController::class, 'store'])->name('messages.store');
        
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
        Route::get('/profile/edit', [FreelancerController::class, 'editProfile'])->name('freelancer.profile.edit');
        Route::put('/profile/update', [FreelancerController::class, 'updateProfile'])->name('freelancer.profile.update');
        Route::get('/freelancer/profile', [App\Http\Controllers\FreelancerController::class, 'show'])->name('freelancer.profile.show');
        //Route::prefix('profile')->group(function () {
            //Route::get('/', [FreelancerProfileController::class, 'show'])->name('freelancer.profile.show');
           // Route::get('/edit', [FreelancerProfileController::class, 'edit'])->name('freelancer.profile.edit');
            //Route::put('/', [FreelancerProfileController::class, 'update'])->name('freelancer.profile.update');
       // });
    });
    Route::get('/check-user-type', function() {
        $user = \Illuminate\Support\Facades\Auth::user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'is_client' => $user->role === 'cliente'
        ]);
    })->middleware('auth');

    Route::get('/freelancers/{id}', [App\Http\Controllers\FreelancerProfileController::class, 'show'])
        ->name('freelancer.public.profile');
    
    Route::get('/cliente/projects/{project}/avaliar-freelancer', [RatingController::class, 'createFreelancerRating'])->name('cliente.ratings.create');

});