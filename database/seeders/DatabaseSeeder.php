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
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'q',
            'email' => 'admin@admin',
            'role' => '0',
            'password' => 1,
        ]);
        // === Create Schools ===
        $school1 = School::create([
            'name' => 'Baghdad Primary School',
            'type' => 1, // ابتدائي
            'address' => 'Baghdad - Karrada',
            'created_by' => $admin->id
        ]);

        $school2 = School::create([
            'name' => 'Basra High School',
            'type' => 3, // ثانوي
            'address' => 'Basra - Center',
            'created_by' => $admin->id

        ]);

        // === Create Users with Roles ===
        $manager = User::create([
            'name' => 'School Manager Ali',
            'username' => 'w',
            'email' => 'manager@example.com',
            'password' => 1,
            'role' => 1,
            'created_by' => $admin->id

        ]);
        DB::table('school_manager')->insert([
            'user_id' => $manager->id,
            'school_id' => $school1->id,

        ]);

        $userAdminstore = User::create([
            'name' => 'Admin User Sara',
            'username' => 'e',
            'email' => 'admin@example.com',
            'password' => 1,
            'role' => 2,
            'created_by' => $admin->id

        ]);
        DB::table('user_administrator')->insert([
            'user_id' => $userAdminstore->id,
            'school_id' => $school1->id,

        ]);

        $structureManager = User::create([
            'name' => 'Structure Manager Omar',
            'username' => 'r',
            'email' => 'structure@example.com',
            'password' => 1,
            'role' => 3,
            'created_by' => $admin->id

        ]);
        DB::table('structure_manager')->insert([
            'user_id' => $structureManager->id,
            'school_id' => $school1->id,
        ]);


        // === Stages ===
        $stage1 = Stage::create([
            'name' => 'Grade 1',
            'school_id' => $school1->id,
            'created_by' => $structureManager->id
        ]);
        $stage2 = Stage::create([
            'name' => 'Grade 2',
            'school_id' => $school1->id,
            'created_by' => $structureManager->id
        ]);

        $stage3 = Stage::create([
            'name' => 'Grade 10',
            'school_id' => $school2->id,
            'created_by' => $structureManager->id
        ]);
        $stage4 = Stage::create([
            'name' => 'Grade 11',
            'school_id' => $school2->id,
            'created_by' => $structureManager->id
        ]);

        // === Classes ===
        $class1 = SchoolClass::create([
            'name' => '1A',
            'stage_id' => $stage1->id,
            'created_by' => $structureManager->id
        ]);
        $class2 = SchoolClass::create([
            'name' => '2A',
            'stage_id' => $stage2->id,
            'created_by' => $structureManager->id
        ]);
        $class3 = SchoolClass::create([
            'name' => '10A',
            'stage_id' => $stage3->id,
            'created_by' => $structureManager->id
        ]);
        $class4 = SchoolClass::create([
            'name' => '11A',
            'stage_id' => $stage4->id,
            'created_by' => $structureManager->id
        ]);

        // === Subjects ===
        $math = Subject::create([
            'name' => 'Mathematics',
            'stage_id' => $stage1->id,
            'created_by' => $structureManager->id
        ]);
        $arabic = Subject::create([
            'name' => 'Arabic',
            'stage_id' => $stage2->id,
            'created_by' => $structureManager->id
        ]);
        $physics = Subject::create([
            'name' => 'Physics',
            'stage_id' => $stage3->id,
            'created_by' => $structureManager->id
        ]);

        // === Teachers ===
        $teacherUser = User::create([
            'name' => 'Teacher Fatima',
            'username' => 'teacher_fatima',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 4,
            'created_by' => $userAdminstore->id
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
                'created_by' => $userAdminstore->id

            ]);
            Student::create([
                'user_id' => $studentUser->id,
                'class_id' => $class1->id,
                'status' => $i % 2 == 0 ? 0 : 1, // active / transferred
            ]);
        }
    }
}
