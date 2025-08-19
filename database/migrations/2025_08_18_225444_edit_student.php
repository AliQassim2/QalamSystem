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
        Schema::table('students', function (Blueprint $table) {
            // Add a new column for photo
            $table->string('photo')->nullable();
            $table->dropColumn('name'); // Remove the name column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Reverse the changes made in the up method
            $table->dropColumn('photo');
            $table->string('name'); // Re-add the name column
        });
    }
};
