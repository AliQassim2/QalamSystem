<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('school_id')->constrained('schools')->onDelete('restrict');
            $table->date('created_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('deleted_at')->nullable();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('restrict');
        });
        Schema::create('user_administrator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('school_id')->constrained('schools')->onDelete('restrict');
            $table->date('created_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('deleted_at')->nullable();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('restrict');
        });
        Schema::create('structure_manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('school_id')->constrained('schools')->onDelete('restrict');
            $table->date('created_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('deleted_at')->nullable();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_manager');
        Schema::dropIfExists('user_administrator');
        Schema::dropIfExists('structure_manager');
    }
};
