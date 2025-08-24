<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;

Route::prefix('Teacher')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('teacher');
    Route::get('/subject', [SubjectController::class, 'getSubjects'])->name('teacher.subjects');
    Route::get('/class', [ClassController::class, 'getClasses'])->name('teacher.classes');
    Route::get('/s', [StudentController::class, 'getStudents'])->name('teacher.students');
    Route::get('/s/{student}/subjects', [GradeController::class, 'getStudentSubjects'])->name('teacher.student.subjects');
    Route::get('/s/{student}/{subject}', [GradeController::class, 'index'])->name('grades.manage');
    Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
});
