<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::middleware(\App\Http\Middleware\CustomGuest::class)->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login')->withoutMiddleware(\App\Http\Middleware\CustomAuth::class);
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
    Route::get('/send-login-code', [\App\Http\Controllers\Auth\LoginController::class, 'sendLoginCode'])->name('send.login.code');
});

Route::middleware(\App\Http\Middleware\CustomAuth::class)->group(function () {

    Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::middleware(\App\Http\Middleware\isAdmin::class)->group(function () {
        require_once 'Admin.php';
    });

    require_once 'School Manager.php';

    Route::middleware(\App\Http\Middleware\isStructureManager::class)->group(function () {
        require_once 'Structure Manager.php';
    });
    Route::middleware(\App\Http\Middleware\isUserAdministrator::class)->group(function () {
        require_once 'User Administrator.php';
    });
    require_once 'Student.php';
    require_once 'Teacher.php';
    Route::get('{stage}', [\App\Http\Controllers\GeneralController::class, 'getStageData'])->name('account.teachers.links.data');
    Route::get('/teacher/stage/{stage}/subjects', [\App\Http\Controllers\TeacherController::class, 'getSubjects']);
    Route::get('/teacher/subject/{subject}/classes', [\App\Http\Controllers\TeacherController::class, 'getClasses']);
    Route::get('/teacher/class/{class}/students', [\App\Http\Controllers\TeacherController::class, 'getStudents']);
});
