<?php


use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    // Rota para o dashboard do cliente
    Route::get('/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');
    
    // Outras rotas relacionadas ao cliente
    Route::get('/meus-projetos', [ClienteController::class, 'projects'])->name('cliente.projects');
    Route::post('/publicar-projeto', [ClienteController::class, 'storeProject'])->name('cliente.storeProject');
});

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::resource('projects', ProjectController::class);
});
