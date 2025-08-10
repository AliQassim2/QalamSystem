<?php

use Illuminate\Support\Facades\Route;

Route::prefix('Dashboard')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/settings', 'DashboardController@settings')->name('dashboard.settings');
});
