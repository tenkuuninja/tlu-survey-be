<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('grade_level_id')->nullable();
            $table->foreign('grade_level_id')->references('id')->on('grade_levels')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->integer('status');
            $table->string('created_name')->nullable();
            $table->string('updated_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classses');
    }
};
