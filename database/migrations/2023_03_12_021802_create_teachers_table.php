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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password_hashed');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('phone_number');
            $table->integer('sex');
            $table->integer('status');
            $table->string('created_name');
            $table->string('updated_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
