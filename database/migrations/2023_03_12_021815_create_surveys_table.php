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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_option_id')->nullable();
            $table->foreign('survey_option_id')->references('id')->on('survey_options')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code');
            $table->string('title')->nullable()->default('');
            $table->string('note')->nullable()->default('');
            $table->integer('status')->nullable()->default(0);
            $table->foreignId('created_by_teacher')->nullable();
            $table->foreign('created_by_teacher')->references('id')->on('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('created_by_admin')->nullable();
            $table->foreign('created_by_admin')->references('id')->on('admins')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('last_modified_by_teacher')->nullable();
            $table->foreign('last_modified_by_teacher')->references('id')->on('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('last_modified_by_admin')->nullable();
            $table->foreign('last_modified_by_admin')->references('id')->on('admins')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
