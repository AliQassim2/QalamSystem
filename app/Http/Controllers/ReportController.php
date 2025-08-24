<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    private function getDuplicateNames()
    {
        $getNames = DB::select('
        SELECT u.name, COUNT(*) as count
        FROM users as u Join students as st on u.id = st.user_id
        join classes as c on st.class_id = c.id
        join stages as s on c.stage_id = s.id
        WHERE s.school_id = ? AND u.role=5
        GROUP BY u.name
        HAVING COUNT(*) > 1;
    ', [Auth::user()->schoolManager->school_id]);

        foreach ($getNames as $name) {
            $query = "SELECT u.id, u.username ,s.name as 'stageName',c.name as 'className'
            FROM users as u Join students as st on u.id = st.user_id
            join classes as c on st.class_id = c.id
            join stages as s on c.stage_id = s.id
            WHERE s.school_id = ? AND u.name = ? AND u.role=5;";
            $users = DB::select($query, [Auth::user()->schoolManager->school_id, $name->name]);

            // attach all users with that name
            $name->info = $users;
        }

        return $getNames;
    }

    private function getMultiSubjectTeachers()
    {
        $query = " select t.id,u.name from teachers as t join
        (SELECT l.teacher_id
        FROM teachers as t
        join users as u on t.user_id = u.id
        join links as l on t.id = l.teacher_id
        join subjects as sub on l.subject_id = sub.id
        join stages as st on sub.stage_id = st.id
        WHERE st.school_id = ? and u.role=4
        GROUP BY l.teacher_id
        HAVING COUNT(DISTINCT l.subject_id) > 1) AS temp on t.id = temp.teacher_id
        join users as u on t.user_id = u.id";
        $getTeachers = DB::select($query, [Auth::user()->schoolManager->school_id]);
        foreach ($getTeachers as $teacher) {
            $teacher->subjects = DB::select("
                SELECT DISTINCT sub.name
                FROM subjects as sub
                join links as l on sub.id = l.subject_id
                WHERE l.teacher_id = ?
            ", [$teacher->id]);
        }
        return $getTeachers;
    }


    public function getStudentsMissingGrades()
    {
        $query = "
                SELECT u.id, u.name, c.name as 'className', s.name as 'stageName'
                FROM users as u
                JOIN students as st ON u.id = st.user_id
                JOIN classes as c ON st.class_id = c.id
                JOIN stages as s ON c.stage_id = s.id
                WHERE s.school_id = ? AND u.role=5 LIMIT 3";
        $getStudents = DB::select($query, [Auth::user()->schoolManager->school_id]);
        foreach ($getStudents as $student) {
            $query = "
                SELECT DISTINCT sub.name as 'subjectName'
                FROM grades as g
                JOIN subjects as sub ON g.subject_id = sub.id
                WHERE g.student_id = ? AND g.score IS NULL
            ";
            $student->missingSubjects = DB::select($query, [$student->id]);
        }
        $count = DB::select('SELECT COUNT(*) as count
                FROM users as u
                JOIN students as st ON u.id = st.user_id
                JOIN classes as c ON st.class_id = c.id
                JOIN stages as s ON c.stage_id = s.id
                WHERE s.school_id = ? AND u.role=5', [Auth::user()->schoolManager->school_id]);
        $getStudentsCount = $count[0]->count;
        return [$getStudents, $getStudentsCount];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dublicateNames = $this->getDuplicateNames();
        $multiSubjectTeachers = $this->getMultiSubjectTeachers();
        $studentsMissingGrades = $this->getStudentsMissingGrades()[0];
        $studentsMissingGradesCount = $this->getStudentsMissingGrades()[1];
        return view('manager.report', compact('dublicateNames', 'multiSubjectTeachers', 'studentsMissingGrades', 'studentsMissingGradesCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
