<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\School;
use App\Models\Stage;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Create Schools ===
        $school1 = School::create([
            'name' => 'Baghdad Primary School',
            'type' => 1, // ابتدائي
            'address' => 'Baghdad - Karrada',
        ]);

        $school2 = School::create([
            'name' => 'Basra High School',
            'type' => 3, // ثانوي
            'address' => 'Basra - Center',
        ]);

        // === Create Users with Roles ===
        $manager = User::create([
            'name' => 'School Manager Ali',
            'username' => 'manager_ali',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);
        DB::table('school_manager')->insert([
            'user_id' => $manager->id,
            'school_id' => $school1->id,
        ]);

        $admin = User::create([
            'name' => 'Admin User Sara',
            'username' => 'admin_sara',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);
        DB::table('user_administrator')->insert([
            'user_id' => $admin->id,
            'school_id' => $school1->id,
        ]);

        $structureManager = User::create([
            'name' => 'Structure Manager Omar',
            'username' => 'structure_omar',
            'email' => 'structure@example.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);
        DB::table('structure_manager')->insert([
            'user_id' => $structureManager->id,
            'school_id' => $school1->id,
        ]);

        // === Stages ===
        $stage1 = Stage::create(['name' => 'Grade 1', 'school_id' => $school1->id]);
        $stage2 = Stage::create(['name' => 'Grade 2', 'school_id' => $school1->id]);

        $stage3 = Stage::create(['name' => 'Grade 10', 'school_id' => $school2->id]);
        $stage4 = Stage::create(['name' => 'Grade 11', 'school_id' => $school2->id]);

        // === Classes ===
        $class1 = SchoolClass::create(['name' => '1A', 'stage_id' => $stage1->id]);
        $class2 = SchoolClass::create(['name' => '2A', 'stage_id' => $stage2->id]);
        $class3 = SchoolClass::create(['name' => '10A', 'stage_id' => $stage3->id]);
        $class4 = SchoolClass::create(['name' => '11A', 'stage_id' => $stage4->id]);

        // === Subjects ===
        $math = Subject::create(['name' => 'Mathematics', 'stage_id' => $stage1->id]);
        $arabic = Subject::create(['name' => 'Arabic', 'stage_id' => $stage2->id]);
        $physics = Subject::create(['name' => 'Physics', 'stage_id' => $stage3->id]);

        // === Teachers ===
        $teacherUser = User::create([
            'name' => 'Teacher Fatima',
            'username' => 'teacher_fatima',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 4,
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'school_id' => $school1->id,
        ]);

        // === Students ===
        for ($i = 1; $i <= 5; $i++) {
            $studentUser = User::create([
                'name' => "Student $i",
                'username' => "student$i sadfsd",
                'email' => "student$i@example.com",
                'password' => Hash::make('password'),
                'role' => 5,
            ]);
            Student::create([
                'user_id' => $studentUser->id,
                'class_id' => $class1->id,
                'status' => $i % 2 == 0 ? 0 : 1, // active / transferred
            ]);
        }
    }
}
