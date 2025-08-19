<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\GeneralController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;


Route::prefix('AccountManager')->group(function () {
    Route::get('/', [GeneralController::class, 'viewAccounts'])->name('account.home');
    Route::get('students', [StudentController::class, 'index'])->name('account.students');
    Route::get('students/create', [StudentController::class, 'create'])->name('account.students.create');
    Route::get('students/{student}', [StudentController::class, 'show'])->name('account.students.show');
    Route::post('students', [StudentController::class, 'store'])->name('account.students.store');
    Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('account.students.edit');
    Route::put('students/{student}', [StudentController::class, 'update'])->name('account.students.update');
    Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('account.students.destroy');
    Route::get('teachers', [TeacherController::class, 'index'])->name('account.teachers');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('account.teachers.create');
    Route::get('teachers/{teacher}', [TeacherController::class, 'show'])->name('account.teachers.show');
    Route::post('teachers', [TeacherController::class, 'store'])->name('account.teachers.store');
    Route::get('teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('account.teachers.edit');
    Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('account.teachers.update');
    Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy'])->name('account.teachers.destroy');
    Route::get('teachers/{teacher}/links', [TeacherController::class, 'viewLinks'])->name('account.teachers.links');
    Route::post('teachers/{teacher}/links', [TeacherController::class, 'storeLink'])->name('account.teachers.links.store');
    Route::delete('teachers/{teacher}/links', [TeacherController::class, 'destroyLink'])->name('account.teachers.links.destroy');
});
