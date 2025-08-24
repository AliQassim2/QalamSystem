<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns to existing grades table
        Schema::table('grades', function (Blueprint $table) {
            $table->tinyInteger('type')->comment('0:mid1, 1:mid2, 2:MidFinal , 3:mid3,4:mid4, 5:final')->default(1);
            $table->text('notes')->nullable();
            $table->string('score')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['type', 'notes']);
        });
    }
};
