<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\GeneralController;

Route::prefix('StructureManager')->group(function () {

    Route::get('/', [GeneralController::class, 'viewStructure'])->name('StructureManager.home');
    Route::get('stages', [StageController::class, 'index'])->name('StructureManager.Stages');
    Route::post('stages', [StageController::class, 'store'])->name('StructureManager.Stages.store');
    Route::put('stages/{id}', [StageController::class, 'update'])->name('StructureManager.Stages.update');
    Route::delete('stages/{stage}', [StageController::class, 'destroy'])->name('StructureManager.Stages.destroy');
    Route::get('/classes', [ClassController::class, 'index'])->name('StructureManager.Classes');
    Route::view('/subjects', 'school_structure.subject.index')->name('StructureManager.Subjects');
});
