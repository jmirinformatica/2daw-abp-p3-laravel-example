<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

// Les meves rutes

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/language/{locale}', [SiteController::class, 'language'])->name('language');

Route::get('/contact', [SiteController::class, 'contact'])->name('contact.form');
Route::post('/contact', [SiteController::class, 'sendMail'])->name('contact.send');

// Llistat i consulta d'entrades publicades (públiques)
Route::resource('posts', PostController::class)
    ->only(['index', 'show']);

// Gestió d'entrades (requereix autenticació)
Route::resource('posts', PostController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

// Rutes personalitzades d'usuari autenticat
Route::controller(PostController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('posts/{post}/delete', 'delete')
            ->name('posts.delete');
        Route::get('my-posts', 'myIndex')
            ->name('posts.myIndex');
    });

// Gestió de comentaris (requereix autenticació)
Route::resource('posts.comments', CommentController::class)
    ->middleware('auth');