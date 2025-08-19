<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function viewStructure()
    {
        $school = Auth::user()->structureManager->school;

        $stagesCount = $school->stages()->count();
        $classesCount = $school->classes()->count();
        $subjectsCount = $school->subjects()->count();
        return view('school_structure.index', compact([
            'stagesCount',
            'classesCount',
            'subjectsCount',
        ]));
    }

    public function viewAccounts()
    {
        $school = Auth::user()->userAdministrator->school;

        $studentCount = $school->students()->count();
        $teacherCount = $school->teachers()->count();
        // $SchoolManagerCount = $school->SchoolManager()->count();
        // $UserAdministratorCount = $school->UserAdministrator()->where('id', '!=', Auth::user()->userAdministrator->id)->count();
        // $StructureManagerCount = $school->StructureManager()->count();

        return view('user_administrator.index', compact('studentCount', 'teacherCount'));
    }


    public function getStageData(Stage $stage)
    {
        return response()->json([
            'classes' => $stage->classes()->select('id', 'name')->get(),
            'subjects' => $stage->subjects()->select('id', 'name')->get(),
        ]);
    }
}
