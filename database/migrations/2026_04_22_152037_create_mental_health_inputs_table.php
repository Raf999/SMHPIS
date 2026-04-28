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
        Schema::create('mental_health_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_profiles')->onDelete('cascade');

            $table->integer('age');
            $table->float('gpa');
            $table->integer('stress');
            $table->integer('anxiety');
            $table->float('sleep');
            $table->integer('mood');
            $table->text('reflection')->nullable();
            
            // Additional fields for ML if needed later
            $table->integer('steps_per_day')->default(0);
            $table->float('sentiment_score')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mental_health_inputs');
    }
};
