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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('option_id')->nullable();
            $table->foreign('option_id')->references('id')->on('options')->cascadeOnUpdate()->nullOnDelete();
            $table->string('answer_text')->nullable();
            $table->float('answer_numberic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
