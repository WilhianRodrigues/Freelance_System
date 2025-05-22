<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sobre a plataforma
/*Route::get('/sobre', [AboutController::class, 'index'])->name('about');

// Contato
Route::get('/contato', [ContactController::class, 'index'])->name('contact');

// Termos de uso
Route::get('/termos-de-uso', function () {
    return view('geral.termos');  // Uma view com os termos de uso
})->name('terms');

// Política de privacidade
Route::get('/politica-de-privacidade', function () {
    return view('geral.privacy');  // Uma view com a política de privacidade
})->name('privacy');

// FAQs
Route::get('/faq', function () {
    return view('geral.faq');  // Uma view com perguntas frequentes
})->name('faq');*/
