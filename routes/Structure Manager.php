<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\GeneralController;

Route::prefix('StructureManager')->group(function () {

    Route::get('/', [GeneralController::class, 'viewStructure'])->name('StructureManager.home');
    Route::get('/classes', [ClassController::class, 'index'])->name('StructureManager.Classes');
    Route::view('/stages', 'school_structure.stages.index')->name('StructureManager.Stages');
    Route::view('/subjects', 'school_structure.subject.index')->name('StructureManager.Subjects');
});
