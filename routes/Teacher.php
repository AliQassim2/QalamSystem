<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SubjectController;

Route::prefix('Teacher')->group(function () {
    Route::view('/', 'teachers.index')->name('Teacher');
});
