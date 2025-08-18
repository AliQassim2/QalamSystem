<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SubjectController;

Route::prefix('StructureManager')->group(function () {

    Route::get('/', [GeneralController::class, 'viewStructure'])->name('StructureManager.home');
    Route::get('stages', [StageController::class, 'index'])->name('StructureManager.Stages');
    Route::post('stages', [StageController::class, 'store'])->name('StructureManager.Stages.store');
    Route::put('stages/{id}', [StageController::class, 'update'])->name('StructureManager.Stages.update');
    Route::delete('stages/{stage}', [StageController::class, 'destroy'])->name('StructureManager.Stages.destroy');
    Route::get('/classes', [ClassController::class, 'index'])->name('StructureManager.Classes');
    Route::post('/classes', [ClassController::class, 'store'])->name('StructureManager.Classes.store');
    Route::put('/classes/{class}', [ClassController::class, 'update'])->name('StructureManager.Classes.update');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('StructureManager.Classes.destroy');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('StructureManager.Subjects');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('StructureManager.Subjects.store');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('StructureManager.Subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('StructureManager.Subjects.destroy');
});
