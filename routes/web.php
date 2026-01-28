<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
    Route::delete('users/{id}/force', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
});

require __DIR__.'/settings.php';
