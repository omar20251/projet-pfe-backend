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
        Schema::create('quiz_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('message');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->string('skill'); //python,java ....
            $table->string('level'); //junior,senior...
            $table->enum('status', ['created', 'completed', 'failed'])->default('created');
            $table->dateTime('requested_at')->useCurrent();
            $table->dateTime('completed_at')->nullable();
            $table->integer('score')->nullable(); // NULL tant que non corrigé
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_requests');
    }
};
