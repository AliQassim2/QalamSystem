<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StructureManager;
use App\Models\SchoolClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{

    public function index()
    {
        $classes = Auth::user()->structureManager->school->classes()->get();
        $stages = Auth::user()->structureManager->school->stages()->get();
        return view('school_structure.classes', compact('classes', 'stages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',

        ]);
        $validated['created_by'] = Auth::user()->id;
        SchoolClass::create($validated);

        return redirect()->back()->with(['success', 'class created successfully.']);
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class->update($validated);
        return redirect()->back()->with(['success' => 'Class edited successfully.']);
    }
    public function destroy(SchoolClass $class)
    {
        try {
            $class->delete();
            return redirect()->back()->with('success', 'Stage deleted successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('StructureManager.Stages')
                    ->with('error', 'Cannot delete this class because it is linked to other records.');
            }
        }
    }
    public function getClasses(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'subject_id' => 'required|exists:subjects,id'
            ]);
            $classes = Auth::user()->teacher->links->where('subject_id', $request->subject_id)->map(function ($link) {
                return [
                    "id" => $link->classes->id,
                    "name" => $link->classes->name
                ];
            })->values();
            return response()->json([
                'success' => true,
                'classes' => $classes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل الصفوف',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
