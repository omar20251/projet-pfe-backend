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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('quiz_request_id')->constrained('quiz_requests')->onDelete('cascade');
            $table->text('question_text');
            $table->json('options');  // ["A) ...", "B) ..."]
            $table->string('correct_answer',1);  // "A", "B", etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
