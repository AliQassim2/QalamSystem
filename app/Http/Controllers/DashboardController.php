<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $TotalUsers = \App\Models\User::whereNot('role', 0)->whereYear('created_at', $request->input('year', now()->year))->count();
        $TotalStudents = \App\Models\Student::whereYear('created_at', $request->input('year', now()->year))->count();
        $TotalSchools = \App\Models\School::whereYear('created_at', $request->input('year', now()->year))->count();
        $TotalTeachers = \App\Models\Teacher::whereYear('created_at', $request->input('year', now()->year))->count();
        return view('Dashboard.index', compact('TotalUsers', 'TotalStudents', 'TotalSchools', 'TotalTeachers'));
    }

    public function viewUsers()
    {
        $users = \App\Models\User::all();
        return view('Dashboard.Users.index', compact('users'));
    }
}
