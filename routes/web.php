<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageUserController;

//Frontend Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cosqueue', [HomeController::class, 'mainCosplayers'])->name('mainCosplayers');
Route::get('/cos/{cosplayerSlug}', [FanController::class, 'displayFans'])->name('fans');

Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    //fan management
    Route::get('/all-fans', [ManageUserController::class, 'allFans'])->name('all-fans');
    //user management
    Route::get('/all-users', [ManageUserController::class, 'allUsers'])->name('all-users')->middleware('superAdmin');
    //cosplayer management
    Route::get('/all-cosplayers', [ManageUserController::class, 'allCosplayers'])->name('all-cosplayers')->middleware('superAdmin');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
