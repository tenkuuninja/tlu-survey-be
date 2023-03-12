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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dept_id')->nullable();
            $table->foreign('dept_id')->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->integer('credit_number');
            $table->text('description');
            $table->string('created_name');
            $table->string('update_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
