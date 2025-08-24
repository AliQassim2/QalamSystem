<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    // Define methods for handling student-related actions
    public function index()
    {
        if (isset(Auth::user()->userAdministrator->school)) {
            $school = Auth::user()->userAdministrator->school;
            $viewName = 'user_administrator.students.index';
        } else {
            $school = Auth::user()->teacher->school;
            $viewName = 'teachers.index';
        }
        $students = $school->students;
        $stages = $school->stages;
        $classes = $school->classes;
        $subjects = $school->subjects;
        return view($viewName, compact('students', 'classes', 'stages', 'subjects'));
    }

    public function show(Student $student)
    {
        return view('user_administrator.students.show', compact('student'));
    }
    public function search(Request $request, $searchValue)
    {
        $students = Auth::user()->userAdministrator->school->students;
        // Filter students by name or username
        $filtered = $students->filter(function ($student) use ($searchValue) {
            $searchValue = strtolower($searchValue); // case-insensitive
            return str_contains(strtolower($student->user->name), $searchValue)
                || str_contains(strtolower($student->user->username), $searchValue);
        });
        $data = $filtered->map(function ($student) {
            return [
                "StudentName" => $student->user->name,
                "Username"    => $student->user->username,
                "Stage"       => $student->classes->stage->name,
                "Class"       => $student->classes->name,
                "Status"      => $student->status
            ];
        })->toArray();

        return [

            'Data' => $data,
        ];
    }
    public function create()
    {
        $school = Auth::user()->userAdministrator->school;
        $classes = $school->classes;
        $stages = $school->stages;
        return view('user_administrator.students.form', compact('classes', 'stages'));
    }

    public function store(Request $request)
    {
        $validatedDataUser = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:15',
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
        $student = Student::create($validatedDataStudent);

        return redirect()->route('account.students')
            ->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $school = Auth::user()->userAdministrator->school;
        $classes = $school->classes;
        $stages = $school->stages;

        return view('user_administrator.students.form', compact('student', 'classes', 'stages'));
    }

    public function update(Request $request, Student $student)
    {
        $validatedDataUser = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $student->user_id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $validatedDataStudent = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1,2',

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
    public function getStudents(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'class_id' => 'required|exists:classes,id',
                'page' => 'nullable|integer|min:1',
                'search' => 'nullable|string|max:100'
            ]);

            $perPage = 15; // Number of students per page
            $search = $request->get('search', '');

            // Build the query
            $query = Student::where('class_id', $request->class_id)
                ->where('status', 0)
                ->join('users', 'students.user_id', '=', 'users.id')
                ->select(
                    'students.id',
                    'students.created_at',
                    'students.class_id',
                    'users.name'
                );


            $totalWithoutSearch = (clone $query)->count();
            // Apply search if provided
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            }
            // Get total count

            // Get paginated results
            $students = $query->orderBy('name')
                ->paginate($perPage, ['*'], 'page', $request->get('page', 1));

            // Format pagination info
            $pagination = [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
                'from' => $students->firstItem(),
                'to' => $students->lastItem()
            ];

            return response()->json([
                'success' => true,
                'students' => $students,
                'pagination' => $pagination,
                'total_without_search' => $totalWithoutSearch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل الطلاب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student details for grades management
     */
    public function getStudentDetails(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id'
            ]);

            $student = Student::with(['class', 'class.stage', 'grades'])
                ->findOrFail($request->student_id);

            return response()->json([
                'success' => true,
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'student_number' => $student->student_number,
                    'class_name' => $student->class->name,
                    'stage_name' => $student->class->stage->name,
                    'created_at' => $student->created_at->format('Y-m-d')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل بيانات الطالب',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
