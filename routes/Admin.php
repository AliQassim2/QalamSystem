<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UsersController;

Route::prefix('Dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('Dashboard.home');
    Route::get('/schools', [SchoolController::class, 'index'])->name('Dashboard.schools');
    Route::get('/schools.create', [SchoolController::class, 'create'])->name('Dashboard.schools.create');
    Route::post('/schools.store', [SchoolController::class, 'store'])->name('Dashboard.schools.store');
    Route::get('/schools.edit/{school}', [SchoolController::class, 'edit'])->name('Dashboard.schools.edit');
    Route::put('/schools.edit/{school}', [SchoolController::class, 'update'])->name('Dashboard.schools.update');
    Route::delete('/schools.destroy/{school}', [SchoolController::class, 'destroy'])->name('Dashboard.schools.destroy');
    Route::get('/schools.show/{school}', [SchoolController::class, 'show'])->name('Dashboard.schools.show');
    Route::get('/users', [UsersController::class, 'index'])->name('Dashboard.users.index');
    Route::patch('/users/{user}/toggle-state', [UsersController::class, 'toggleState'])->name('Dashboard.users.toggle-state');
    Route::get('/users.create', [UsersController::class, 'create'])->name('Dashboard.users.create');
    Route::post('/users.store', [UsersController::class, 'store'])->name('Dashboard.users.store');
    Route::get('/users.edit/{user}', [UsersController::class, 'edit'])->name('Dashboard.users.edit');
    Route::put('/users.edit/{user}', [UsersController::class, 'update'])->name('Dashboard.users.update');
    Route::delete('/users.destroy/{user}', [UsersController::class, 'destroy'])->name('Dashboard.users.destroy');
});
