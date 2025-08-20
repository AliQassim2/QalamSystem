<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    // Define methods for handling student-related actions
    public function index()
    {
        $school = Auth::user()->userAdministrator->school;
        $students = $school->students;
        $stages = $school->stages;
        $classes = $school->classes;
        return view('user_administrator.students.index', compact('students', 'classes', 'stages'));
    }

    public function show(Student $student)
    {
        return view('user_administrator.students.show', compact('student'));
    }

    public function create()
    {
        $school = Auth::user()->userAdministrator->school;
        $classes = $school->classes;
        return view('user_administrator.students.form', compact('classes'));
    }

    public function store(Request $request)
    {
        $validatedDataUser = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validatedDataStudent = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1,2',
        ]);
        // Handle photo upload if exists
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students', 'public');
            $validatedDataStudent['photo'] = $photoPath;
        }
        $validatedDataUser['role'] = 5;
        $user = User::create($validatedDataUser);
        $validatedDataStudent['user_id'] = $user->id;
        Student::create($validatedDataStudent);

        return redirect()->route('account.students')
            ->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $classes = Auth::user()->userAdministrator->school->classes;
        return view('user_administrator.students.form', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validatedDataUser = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $student->user_id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $validatedDataStudent = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle optional fields elegantly
        $validatedDataStudent['photo'] = $request->hasFile('photo') ? $request->file('photo')->store('students', 'public') : null;

        // Remove null keys so they won’t overwrite existing values
        $validatedDataStudent = array_filter($validatedDataStudent, fn($value) => !is_null($value));
        $validatedDataUser = array_filter($validatedDataUser, fn($value) => !is_null($value));

        // Update user & student
        $student->user->update($validatedDataUser);
        $student->update($validatedDataStudent);

        return redirect()->route('account.students')
            ->with('success', 'Student updated successfully.');
    }


    public function destroy(Student $student)
    {

        try {
            $student->delete();
            $student->user->delete();
            return redirect()->route('account.students')
                ->with('success', 'Student deleted successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('account.students')
                    ->with('error', ' This student is linked to other records and cannot be deleted.');
            }
            return redirect()->route('account.students')
                ->with('error', 'Failed to delete student.');
        }
    }
}
