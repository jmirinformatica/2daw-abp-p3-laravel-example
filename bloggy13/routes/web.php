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

Route::resource('posts', PostController::class)
    ->middleware(['auth']);

Route::controller(PostController::class)->group(function () {
    Route::get('posts/{post}/delete', 'delete')
        ->name('posts.delete');
    Route::get('my-posts', 'myIndex')
        ->name('posts.myIndex');
})->middleware(['auth']);

Route::resource('posts.comments', CommentController::class)
    ->middleware(['auth']);