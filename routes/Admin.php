<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UsersController;

Route::prefix('Dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.home');
    Route::get('/schools', [SchoolController::class, 'index'])->name('dashboard.schools');
    Route::get('/schools.create', [SchoolController::class, 'create'])->name('dashboard.schools.create');
    Route::post('/schools.store', [SchoolController::class, 'store'])->name('dashboard.schools.store');
    Route::get('/schools.edit/{school}', [SchoolController::class, 'edit'])->name('dashboard.schools.edit');
    Route::put('/schools.edit/{school}', [SchoolController::class, 'update'])->name('dashboard.schools.update');
    Route::delete('/schools.destroy/{school}', [SchoolController::class, 'destroy'])->name('dashboard.schools.destroy');
    Route::get('/users', [UsersController::class, 'index'])->name('dashboard.users.index');
    Route::patch('/users/{user}/toggle-state', [UsersController::class, 'toggleState'])->name('dashboard.users.toggle-state');
    Route::get('/users.create', [UsersController::class, 'create'])->name('dashboard.users.create');
    Route::post('/users.store', [UsersController::class, 'store'])->name('dashboard.users.store');
    Route::get('/users.edit/{user}', [UsersController::class, 'edit'])->name('dashboard.users.edit');
    Route::put('/users.edit/{user}', [UsersController::class, 'update'])->name('dashboard.users.update');
    Route::delete('/users.destroy/{user}', [UsersController::class, 'destroy'])->name('dashboard.users.destroy');
});
