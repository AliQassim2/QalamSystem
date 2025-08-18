<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;

class SchoolController extends Controller
{
    private function calculateSchoolStats()
    {
        $total = School::count();
        $byType = School::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        return [
            'total' => $total,
            'elementary' => $byType['1'] ?? 0,
            'middle' => $byType['2'] ?? 0,
            'high' => $byType['3'] ?? 0,
            'secondary' => $byType['4'] ?? 0,
        ];
    }
    public function index(Request $request)
    {
        // Get the query builder
        $query = School::query();


        // Get paginated results
        $schools = $query->paginate(12)->withQueryString();

        // Calculate statistics
        $stats = $this->calculateSchoolStats();

        return view('Dashboard.schools.index', compact('schools', 'stats'));
    }
    public function create()
    {
        return view('Dashboard.schools.form');
    }

    public function edit(School $school)
    {
        return view('Dashboard.schools.form', compact('school'));
    }

    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|integer|in:1,2,3,4', // 1: ابتدائي, 2: متوسط, 3: ثانوي, 4: اعدادي
            'address' => 'nullable|string|max:500',
            'logo'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB
        ]);

        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            // Save to storage/app/public/school_logos
            $path = $request->file('logo')->store('school_logos', 'public');
            $validated['logo_path'] = 'storage/' . $path; // Accessible from public
            unset($validated['logo']);
        }
        $validated['created_by'] = auth()->id(); // Set the creator ID
        // Create the school

        School::create($validated);

        // Redirect with success message
        return redirect()
            ->route('Dashboard.schools')
            ->with('success', 'School created successfully.');
    }

    public function update(Request $request, School $school)
    {  // Validate form data
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|integer|in:1,2,3,4', // 1: ابتدائي, 2: متوسط, 3: ثانوي, 4: اعدادي
            'address' => 'nullable|string|max:500',
            'logo'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB
        ]);

        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            // Save to storage/app/public/school_logos
            $path = $request->file('logo')->store('school_logos', 'public');
            $validated['logo_path'] = 'storage/' . $path; // Accessible from public
        }

        // Update the school
        $school->update($validated);

        // Redirect with success message
        return redirect()
            ->route('Dashboard.schools')
            ->with('success', 'School updated successfully.');
    }
    public function destroy(School $school)
    {
        try {
            // Soft delete the school
            $school->delete();

            // Redirect with success message
            return redirect()
                ->route('Dashboard.schools')
                ->with('success', 'School deleted successfully.');
        } catch (QueryException $e) {
            // Check if it's a foreign key constraint violation
            if ($e->errorInfo[1] == 1451) {
                return redirect()
                    ->route('Dashboard.schools')
                    ->with('error', 'Cannot delete school with existing related records.');
            }
            // Handle any other errors
            return redirect()
                ->route('Dashboard.schools')
                ->with('error', 'Failed to delete school.');
        }
    }
    public function show(School $school)
    {
        $school->load(['students.user', 'teachers', 'creator', 'stages', 'classes', 'subjects']);
        return view('Dashboard.schools.show', compact('school'));
    }
}
