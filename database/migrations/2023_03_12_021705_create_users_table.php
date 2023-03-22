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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('grade_level_id')->nullable();
            $table->foreign('grade_level_id')->references('id')->on('grade_levels')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('citizen_id')->nullable();
            $table->integer('sex');
            $table->integer('status');
            $table->string('role')->default('student');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
