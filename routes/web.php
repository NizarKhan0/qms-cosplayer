<?php

use App\Http\Controllers\ManageUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FanController;
use App\Http\Controllers\HomeController;

//Frontend Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('cosplayer-{cosplayerId}', [FanController::class, 'displayFans'])->name('fans');

//Backend
Route::view('dashboard', 'backend.dashboard')
    // ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('all-users', [ManageUserController::class, 'allUsers'])->name('all-users');
    Route::get('all-cosplayers', [ManageUserController::class, 'allCosplayers'])->name('all-cosplayers');
    Route::get('all-fans', [ManageUserController::class, 'allFans'])->name('all-fans');

});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
