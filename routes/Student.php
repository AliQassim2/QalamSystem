<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentGradesController;

Route::prefix('Student')->group(function () {
    Route::get('/', [StudentGradesController::class, 'index'])->name('students');
    Route::get('/{student}', [StudentGradesController::class, 'show'])->name('students.show');
    Route::post('/', [StudentGradesController::class, 'store'])->name('students.store');
});
