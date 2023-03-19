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
        Schema::create('survey_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->nullable();
            $table->foreign('survey_id')->references('id')->on('surveys')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('limit')->default(0);
            $table->boolean('process_bar')->default(0);
            $table->boolean('shuffle_question_order')->default(0);
            $table->boolean('view_results')->default(0);
            $table->boolean('public')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_options');
    }
};
