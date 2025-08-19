<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\GeneralController;
use App\Http\Controllers\StudentController;


Route::prefix('AccountManager')->group(function () {
    Route::get('/', [GeneralController::class, 'viewAccounts'])->name('account.home');
    Route::get('students', [StudentController::class, 'index'])->name('account.students');
    Route::get('students/create', [StudentController::class, 'create'])->name('account.students.create');
    Route::get('students/{student}', [StudentController::class, 'show'])->name('account.students.show');
    Route::post('students', [StudentController::class, 'store'])->name('account.students.store');
    Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('account.students.edit');
    Route::put('students/{student}', [StudentController::class, 'update'])->name('account.students.update');
    Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('account.students.destroy');
});
