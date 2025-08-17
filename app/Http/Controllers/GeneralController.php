<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function viewStructure()
    {
        $school = Auth::user()->structureManager->school;

        $stageCount = $school->stages()->count();
        $classCount = $school->classes()->count();
        $subjectCount = $school->subjects()->count();
        return view('school_structure.index', [
            'stagesCount' => $stageCount,
            'classesCount' => $classCount,
            'subjectsCount' => $subjectCount,
        ]);
    }
}
