<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schools
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('address')->nullable();
            $table->enum('type', ['ابتدائي', 'متوسط', 'ثانوي', 'اعدادي']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Stages
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('school_id')->nullable()->constrained('schools')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Classes
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('stage_id')->nullable()->constrained('stages')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('stage_id')->nullable()->constrained('stages')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('school_id')->nullable()->constrained('schools')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Links (composite primary key)
        Schema::create('links', function (Blueprint $table) {
            $table->foreignId('class_id')->constrained('classes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('teacher_id')->constrained('teachers')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_id')->constrained('subjects')->restrictOnDelete()->cascadeOnUpdate();
            $table->primary(['class_id', 'teacher_id', 'subject_id']);
        });

        // Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('class_id')->nullable()->constrained('classes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });

        // Grades
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('student_id')->nullable()->constrained('students')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('students');
        Schema::dropIfExists('links');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('stages');
        Schema::dropIfExists('schools');
    }
};
