<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Student $student, Subject $subject)
    {
        $grades = $student->grades()
            ->where('subject_id', $subject->id)
            ->orderBy('type')
            ->get();
        if ($grades->count() == 0) {
            for ($i = 0; $i < 6; $i++) {
                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'type' => $i,
                    'updated_at' => null
                ]);
            }
        }
        $grades = $student->grades()
            ->where('subject_id', $subject->id)
            ->orderBy('type')
            ->get();
        $gradeRatio = [
            "A" => 90,
            "B" => 80,
            "C" => 70,
            "D" => 60,
            "E" => 50,
            "F" => 0,
        ];

        // Default grade
        $letterGrade = 'غير متوفر';
        $ratios = 0;
        // Helper: get score by type
        $getScore = fn(int $type) => optional($grades->firstWhere('type', $type))->score ?? 0;

        // Calculate averages
        $firstMid   = ($getScore(0) + $getScore(1)) / 2;
        $midFinal   = $getScore(2);
        $secondMid  = ($getScore(3) + $getScore(4)) / 2;
        $finalExam  = $getScore(5);

        // Final result
        $finalResult = ($firstMid + $midFinal + $secondMid + $finalExam) / 4;
        $ratios = $finalResult;
        // Ensure all 6 grades exist with a score
        if ($grades->whereNotNull('score')->count() === 6) {
            // Determine grade letter
            foreach ($gradeRatio as $letter => $minScore) {
                if ($finalResult >= $minScore) {
                    $letterGrade = $letter;
                    break;
                }
            }
        }

        return view('Teachers.grades', compact('student', 'grades', 'subject', 'ratios', 'letterGrade', 'firstMid', 'midFinal', 'secondMid', 'finalExam', 'finalResult'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $validatedData = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:255',
        ]);
        $grade->score = $validatedData['score'];
        $grade->notes = $validatedData['notes'];
        $grade->updated_at = now();
        $grade->save();

        return redirect()->back()->with('success', 'تم تحديث الدرجة بنجاح.');
    }



    public function getStudentSubjects(Request $request, Student $student)
    {
        try {
            // Get subjects that the teacher teaches in this student's class
            $subjects = $student->classes->subjects()->select('id', 'name')->orderBy('name')->get();

            return response()->json([
                'success' => true,
                'subjects' => $subjects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل المواد'
            ], 500);
        }
    }
}
