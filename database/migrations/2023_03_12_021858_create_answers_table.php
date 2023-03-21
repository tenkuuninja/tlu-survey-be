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
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('survey_id')->nullable();
            $table->foreign('survey_id')->references('id')->on('surveys')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('option_id')->nullable();
            $table->foreign('option_id')->references('id')->on('options')->cascadeOnUpdate()->cascadeOnDelete();
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
