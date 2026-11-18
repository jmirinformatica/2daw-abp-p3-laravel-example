<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

// Les meves rutes

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/language/{locale}', [SiteController::class, 'language'])->name('language');

Route::get('/contact', [SiteController::class, 'contact'])->name('contact.form');
Route::post('/contact', [SiteController::class, 'sendMail'])->name('contact.send');