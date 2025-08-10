<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $TotalUsers = \App\Models\User::count();
        $TotalStudents = \App\Models\Student::count();
        return view('dashboard.index', compact('TotalUsers', 'TotalStudents'));
    }
}
