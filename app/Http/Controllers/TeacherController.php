<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school = Auth::user()->userAdministrator->school; // Get the school of the authenticated user
        $teachers = $school->teachers; // Get all teachers associated with the school
        $stages = $school->stages; // Get all stages associated with the school
        $subjects = $school->subjects; // Get all subjects associated with the school
        return view('user_administrator.teachers.index', compact('teachers', 'stages', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user_administrator.teachers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $school = Auth::user()->userAdministrator->school; // Get the school of the authenticated user
        $validatedData['role'] = 4;
        $user = User::create($validatedData);
        Teacher::create([
            'user_id' => $user->id,
            'school_id' => $school->id,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('account.teachers')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('user_administrator.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('user_administrator.teachers.form', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $teacher->user_id,
            'email' => 'required|email|max:255|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!$request->filled('password')) {
            unset($validatedData['password']);
        }
        $teacher->user->update($validatedData);
        return redirect()->route('account.teachers')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            $teacher->user->delete();
            return redirect()->route('account.teachers')
                ->with('success', 'Teacher deleted successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('account.teachers')
                    ->with('error', ' This teacher is linked to other records and cannot be deleted.');
            }
            return redirect()->route('account.teachers')
                ->with('error', 'Failed to delete teacher.');
        }
    }

    public function viewLinks(Teacher $teacher)
    {
        $school = Auth::user()->userAdministrator->school; // Get the school of the authenticated user
        $stages = $school->stages; // Get all stages associated with the teacher
        $classes = $school->classes; // Get all classes associated with the teacher
        $links = $teacher->links; // Get all links associated with the teacher
        return view('user_administrator.teachers.links', compact('teacher', 'links', 'stages', 'classes'));
    }
    public function storeLink(Request $request, Teacher $teacher)
    {
        try {
            $validatedData = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
            ]);
            $validatedData['teacher_id'] = $teacher->id;
            $teacher->links()->create($validatedData);
            return redirect()->route('account.teachers.links', $teacher)->with('success', 'Link created successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('account.teachers.links', $teacher)
                    ->with('error', 'This link already exists.');
            }
            return redirect()->route('account.teachers.links', $teacher)
                ->with('error', 'Failed to create link.');
        }
    }

    public function destroyLink(Request $request, Teacher $teacher)
    {
        Link::where('teacher_id', $teacher->id)
            ->where('class_id', $request->input('class_id'))
            ->where('subject_id', $request->input('subject_id'))
            ->delete();
        return redirect()->route('account.teachers.links', $teacher)->with('success', 'Link deleted successfully.');
    }
    public function getSubjects(Stage $stage)
    {
        return $stage->subjects()->select('id', 'name')->get();
    }

    public function getClasses(Subject $subject)
    {
        return $subject->classes()->select('id', 'name')->get();
    }

    public function getStudents(SchoolClass $class)
    {
        return $class->students()->with('user:id,name,username')->get();
    }
}
