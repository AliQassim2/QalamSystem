<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\User;

class StudentGradesController extends Controller
{
    /**
     * Display student grades dashboard
     */
    public function index()
    {
        try {
            // Get the authenticated student
            $user = Auth::user();


            // Get student record with relationships
            $student = $user->student;

            // Get subjects for the student's class/stage
            $subjects = Subject::where('stage_id', $student->stage->id)
                ->orderBy('name')
                ->get();

            // Get all grades for this student
            $grades = Auth::user()->student->grades;

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
            // Calculate additional statistics
            $statistics = $this->calculateStatistics($student, $subjects, $grades);

            return view('students.index', compact(
                'student',
                'subjects',
                'grades',
                'statistics',
                'ratios',
                'letterGrade'
            ));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Get detailed grades for a specific subject (AJAX)
     */
    public function getSubjectGrades(Request $request, $subjectId)
    {
        try {
            $user = Auth::user();
            $student = Student::where('user_id', $user->id)->firstOrFail();

            // Get subject details
            $subject = Subject::findOrFail($subjectId);

            // Get all grades for this subject and student
            $grades = Grade::where('student_id', $student->id)
                ->where('subject_id', $subjectId)
                ->get();

            // Create array for all 6 grade types
            $gradeTypes = [
                0 => 'الشهري الأول - الفصل الأول',
                1 => 'الشهري الثاني - الفصل الأول',
                2 => 'نصف السنة',
                3 => 'الشهري الأول - الفصل الثاني',
                4 => 'الشهري الثاني - الفصل الثاني',
                5 => 'الامتحان النهائي'
            ];

            $detailedGrades = [];

            for ($i = 0; $i < 6; $i++) {
                $grade = $grades->where('type', $i)->first();

                $detailedGrades[] = [
                    'type' => $i,
                    'type_name' => $gradeTypes[$i],
                    'score' => $grade ? $grade->score : null,
                    'notes' => $grade ? $grade->notes : null,
                    'date' => $grade ? $grade->updated_at->format('Y-m-d') : null,
                    'has_score' => $grade && $grade->score !== null
                ];
            }

            // Calculate subject statistics
            $subjectStats = $this->calculateSubjectStatistics($grades);

            return response()->json([
                'success' => true,
                'subject' => $subject,
                'grades' => $detailedGrades,
                'statistics' => $subjectStats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل تفاصيل المادة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate overall statistics for the student
     */
    private function calculateStatistics($student, $subjects, $grades)
    {
        $totalSubjects = $subjects->count();
        $totalPossibleExams = $totalSubjects * 6; // 6 exams per subject
        $completedExams = $grades->whereNotNull('score')->count();
        $remainingExams = $totalPossibleExams - $completedExams;

        // Calculate overall average
        $overallAverage = $completedExams > 0 ?
            round($grades->whereNotNull('score')->avg('score'), 1) : 0;

        // Calculate completed subjects (subjects with all 6 exams done)
        $completedSubjects = 0;
        $subjectAverages = [];
        $letterGrades = [];

        foreach ($subjects as $subject) {
            $subjectGrades = $grades->where('subject_id', $subject->id);
            $subjectCompletedGrades = $subjectGrades->whereNotNull('score');

            if ($subjectCompletedGrades->count() == 6) {
                $completedSubjects++;
                $average = round($subjectCompletedGrades->avg('score'), 1);
                $subjectAverages[] = $average;
                $letterGrades[] = $this->calculateLetterGrade($average);
            }
        }

        // Calculate GPA if any subjects are completed
        $gpa = !empty($subjectAverages) ? round(array_sum($subjectAverages) / count($subjectAverages), 1) : 0;

        // Performance indicators
        $performance = $this->getPerformanceLevel($overallAverage);

        return [
            'total_subjects' => $totalSubjects,
            'completed_subjects' => $completedSubjects,
            'total_exams' => $totalPossibleExams,
            'completed_exams' => $completedExams,
            'remaining_exams' => $remainingExams,
            'overall_average' => $overallAverage,
            'gpa' => $gpa,
            'completion_percentage' => $totalPossibleExams > 0 ? round(($completedExams / $totalPossibleExams) * 100, 1) : 0,
            'performance_level' => $performance,
            'letter_grades_distribution' => array_count_values($letterGrades)
        ];
    }

    /**
     * Calculate statistics for a specific subject
     */
    private function calculateSubjectStatistics($grades)
    {
        $completedGrades = $grades->whereNotNull('score');
        $completedCount = $completedGrades->count();
        $totalScore = $completedGrades->sum('score');

        $average = $completedCount > 0 ? round($totalScore / $completedCount, 1) : 0;
        $letterGrade = $completedCount == 6 ? $this->calculateLetterGrade($average) : 'غير مكتمل';
        $completionPercentage = round(($completedCount / 6) * 100, 1);

        return [
            'completed_exams' => $completedCount,
            'remaining_exams' => 6 - $completedCount,
            'total_score' => $totalScore,
            'average' => $average,
            'letter_grade' => $letterGrade,
            'completion_percentage' => $completionPercentage,
            'is_completed' => $completedCount == 6
        ];
    }

    /**
     * Calculate letter grade based on average score
     */
    private function calculateLetterGrade($average)
    {
        if ($average >= 90) {
            return 'A';
        } elseif ($average >= 80) {
            return 'B';
        } elseif ($average >= 70) {
            return 'C';
        } elseif ($average >= 60) {
            return 'D';
        } else {
            return 'F';
        }
    }

    /**
     * Get performance level description
     */
    private function getPerformanceLevel($average)
    {
        if ($average >= 90) {
            return [
                'level' => 'ممتاز',
                'color' => '#28a745',
                'icon' => '🌟',
                'description' => 'أداء استثنائي ومتميز'
            ];
        } elseif ($average >= 80) {
            return [
                'level' => 'جيد جداً',
                'color' => '#17a2b8',
                'icon' => '⭐',
                'description' => 'أداء جيد جداً ومستقر'
            ];
        } elseif ($average >= 70) {
            return [
                'level' => 'جيد',
                'color' => '#ffc107',
                'icon' => '👍',
                'description' => 'أداء جيد يحتاج تحسين'
            ];
        } elseif ($average >= 60) {
            return [
                'level' => 'مقبول',
                'color' => '#fd7e14',
                'icon' => '⚠️',
                'description' => 'أداء مقبول يحتاج جهد أكثر'
            ];
        } else {
            return [
                'level' => 'ضعيف',
                'color' => '#dc3545',
                'icon' => '📉',
                'description' => 'أداء يحتاج تحسين فوري'
            ];
        }
    }

    /**
     * Export student grades to PDF (optional feature)
     */
    public function exportToPdf()
    {
        try {
            $user = Auth::user();
            $student = Student::with(['user', 'classes.stage'])->where('user_id', $user->id)->firstOrFail();

            $subjects = Subject::where('stage_id', $student->classes->stage_id)->get();
            $grades = Grade::with(['subject'])->where('student_id', $student->id)->get();
            $statistics = $this->calculateStatistics($student, $subjects, $grades);

            // You can use libraries like DomPDF or TCPDF here
            // For now, return a view that can be printed
            return view('student.grades.pdf', compact('student', 'subjects', 'grades', 'statistics'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ في تصدير الدرجات: ' . $e->getMessage());
        }
    }

    /**
     * Get semester grades summary
     */
    public function getSemesterSummary(Request $request)
    {
        try {
            $user = Auth::user();
            $student = Student::where('user_id', $user->id)->firstOrFail();

            $semester = $request->get('semester', 1); // 1 or 2

            // Define grade types for each semester
            $semesterTypes = $semester == 1 ? [0, 1, 2] : [3, 4, 5];

            $subjects = Subject::where('stage_id', $student->classes->stage_id)->get();

            $semesterData = [];

            foreach ($subjects as $subject) {
                $grades = Grade::where('student_id', $student->id)
                    ->where('subject_id', $subject->id)
                    ->whereIn('type', $semesterTypes)
                    ->get();

                $completedGrades = $grades->whereNotNull('score');
                $average = $completedGrades->count() > 0 ?
                    round($completedGrades->avg('score'), 1) : 0;

                $semesterData[] = [
                    'subject' => $subject,
                    'grades' => $grades,
                    'average' => $average,
                    'completed' => $completedGrades->count(),
                    'total' => 3, // 3 exams per semester
                    'completion_percentage' => round(($completedGrades->count() / 3) * 100, 1)
                ];
            }

            return response()->json([
                'success' => true,
                'semester' => $semester,
                'data' => $semesterData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل ملخص الفصل: ' . $e->getMessage()
            ], 500);
        }
    }
}
