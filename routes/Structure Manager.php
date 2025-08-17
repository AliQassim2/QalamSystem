<?php

use Illuminate\Support\Facades\Route;

Route::prefix('StructureManager')->group(function () {
    Route::view('/', 'school_structure.index')->name('StructureManager.home');
    Route::view('/classes', 'school_structure.classes.index')->name('StructureManager.Classes');
    Route::view('/stages', 'school_structure.stages.index')->name('StructureManager.Stages');
    Route::view('/subjects', 'school_structure.subject.index')->name('StructureManager.Subjects');
});
