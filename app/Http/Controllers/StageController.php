<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class StageController extends Controller
{
    // In your StagesController:
    public function index()
    {
        $stages = Auth::user()->structureManager->school->stages()->get();
        return view('school_structure.stages', compact('stages'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $validatedData['school_id'] = Auth::user()->structureManager->school->id;
        $validatedData['created_by'] = Auth::user()->id;
        Stage::create($validatedData);
        return redirect()->back()->with('success', 'Stage created successfully.');
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $stage = Stage::findOrFail($id);
        $stage->update($validatedData);
        return redirect()->back()->with('success', 'Stage updated successfully.');
    }
    public function destroy(Stage $stage)
    {
        try {
            $stage->delete();
            return redirect()->back()->with('success', 'Stage deleted successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('StructureManager.Stages')
                    ->with('error', 'Cannot delete this stage because it is linked to other records.');
            }
        }
    }
}
