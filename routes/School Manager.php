<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ReportController;

Route::prefix('SchoolManager')->group(function () {
    Route::get('/', [GeneralController::class, 'managerDashboard'])->name('manager.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('manager.reports');
});
