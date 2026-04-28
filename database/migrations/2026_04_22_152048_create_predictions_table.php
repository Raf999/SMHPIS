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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_profiles')->onDelete('cascade');
            $table->foreignId('input_id')->constrained('mental_health_inputs')->onDelete('cascade');

            $table->enum('prediction_result', ['Healthy', 'At Risk', 'Struggling']);
            $table->integer('prediction_class'); // 0,1,2

            $table->float('prob_low')->nullable();
            $table->float('prob_mid')->nullable();
            $table->float('prob_high')->nullable();

            $table->string('model_used')->default('stacked');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
