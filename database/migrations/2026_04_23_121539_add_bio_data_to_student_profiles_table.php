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
        Schema::table('student_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('student_profiles', 'age')) $table->integer('age')->nullable()->after('student_id_number');
            if (!Schema::hasColumn('student_profiles', 'gender')) $table->string('gender')->nullable()->after('age');
            if (!Schema::hasColumn('student_profiles', 'date_of_birth')) $table->date('date_of_birth')->nullable()->after('gender');
            if (!Schema::hasColumn('student_profiles', 'phone')) $table->string('phone')->nullable()->after('date_of_birth');
            if (!Schema::hasColumn('student_profiles', 'department')) $table->string('department')->nullable()->after('phone');
            if (!Schema::hasColumn('student_profiles', 'level')) $table->string('level')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn(['age', 'gender', 'date_of_birth', 'phone', 'department', 'level']);
        });
    }
};
