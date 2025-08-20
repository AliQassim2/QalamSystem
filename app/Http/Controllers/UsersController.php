<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::whereNot('role', 0)->whereNot('role', 5)->whereNot('role', 4)->with([
            'creator',
            'schoolManager.school',
            'userAdministrator.school',
            'structureManager.school'
        ])->paginate(15);

        // Role statistics
        $roleStats = [];
        for ($i = 1; $i <= 5; $i++) {
            $roleStats[$i] = User::where('role', $i)->count();
        }

        // Role names mapping
        $roleNames = [
            1 => 'School Manager',
            2 => 'Account Manager',
            3 => 'Structure Manager',
            4 => 'Teacher',
            5 => 'Student'
        ];

        // User schools mapping (for school managers and teachers)
        $userSchools = [];

        foreach ($users as $user) {
            switch ($user->role) {
                case 1: // School Manager
                    if ($user->schoolManager && $user->schoolManager->school) {
                        $userSchools[$user->id] = $user->schoolManager->school->name;
                    }
                    break;

                case 2: // Account Manager
                    if ($user->userAdministrator && $user->userAdministrator->school) {
                        $userSchools[$user->id] = $user->userAdministrator->school->name;
                    }
                    break;

                case 3: // Structure Manager
                    if ($user->structureManager && $user->structureManager->school) {
                        $userSchools[$user->id] = $user->structureManager->school->name;
                    }
                    break;

                case 4: // Teacher
                    if ($user->teacher && $user->teacher->school) {
                        $userSchools[$user->id] = $user->teacher->school->name;
                    }
                    break;

                case 5: // Student
                    if ($user->student && $user->student->school) {
                        $userSchools[$user->id] = $user->student->school->name;
                    }
                    break;
            }
        }


        $activeUsers = User::where('state', 1)->count();

        return view('Dashboard.Users.index', compact('users', 'roleStats', 'roleNames', 'userSchools', 'activeUsers'));
    }

    public function toggleState(User $user)
    {
        $user->state = !$user->state; // Toggle the state
        $user->save();

        $status = $user->state ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "User has been {$status} successfully.");
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();
        return view('Dashboard.Users.form', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:0,1,2',
            'password' => 'required|string|min:8|confirmed',
            'state' => 'required|boolean',
            'school_id' => 'required|integer'
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role + 1,
            'state' => $request->state,
            'password' => bcrypt($request->password),
            'created_by' => auth()->id()
        ]);
        $roles = ['school_manager', 'user_administrator', 'structure_manager'];

        DB::table($roles[$request->role])->insert([
            'user_id' => $user->id,
            'school_id' => $request->school_id,
            'created_at' => now(),
        ]);


        return redirect()->route('Dashboard.users.index')
            ->with('success', 'User created successfully.');
    }


    public function edit(User $user)
    {
        $schools = School::orderBy('name')->get();
        return view('Dashboard.Users.form', compact('user', 'schools'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:0,1,2',
            'password' => 'nullable|string|min:8|confirmed',
            'state' => 'required|boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role + 1,
            'state' => $request->state,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('Dashboard.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('Dashboard.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (QueryException $e) {
            // Check if it's a foreign key constraint violation
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('Dashboard.users.index')
                    ->with('error', 'Cannot delete this user because they have actions linked to other records.');
            }

            // For other DB errors, rethrow
            throw $e;
        }
    }
}
