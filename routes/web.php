<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
// Add these routes for real-time availability checking
Route::post('/check-username', function (Request $request) {
    $exists = User::where('username', $request->username)->exists();
    return response()->json(['available' => !$exists]);
});

Route::post('/check-email', function (Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['available' => !$exists]);
});
Route::middleware(App\Http\Middleware\CustomGuest::class)->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login')->withoutMiddleware(App\Http\Middleware\CustomAuth::class);
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
    Route::get('/send-login-code', [App\Http\Controllers\Auth\LoginController::class, 'sendLoginCode'])->name('send.login.code');
});

Route::middleware(App\Http\Middleware\CustomAuth::class)->group(function () {

    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::middleware(App\Http\Middleware\isAdmin::class)->group(function () {
        require_once 'Admin.php';
    });
    require_once 'School Manager.php';
    require_once 'Structure Manager.php';
    require_once 'Student.php';
    require_once 'Teacher.php';
    require_once 'User Administrator.php';
});
