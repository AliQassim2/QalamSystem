<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Auth::user()->structureManager->school->subjects;
        $stages = Auth::user()->structureManager->school->stages;

        return view('school_structure.subjects', compact('subjects', 'stages'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
        ]);
        $validated['created_by'] = Auth::user()->id;
        Subject::create($validated);
        return redirect()->back()->with(['success' => 'Subject created successfully.']);
    }
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $subject->update($validated);
        return redirect()->back()->with(['success' => 'Subject edited successfully.']);
    }
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return redirect()->back()->with('success', 'Subject deleted successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('StructureManager.Stages')
                    ->with('error', 'Cannot delete this Subject because it is linked to other records.');
            }
        }
    }
}
