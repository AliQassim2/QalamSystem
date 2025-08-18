<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SubjectController;


Route::prefix('AccountManager')->group(function () {
    Route::get('/', [GeneralController::class, 'viewAccounts'])->name('account.home');
});
