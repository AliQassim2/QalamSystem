<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require_once 'Admin.php';
require_once 'School Manager.php';
require_once 'Structure Manager.php';
require_once 'Student.php';
require_once 'Teacher.php';
require_once 'User Administrator.php';
