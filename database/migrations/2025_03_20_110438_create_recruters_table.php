<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recruters', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise_name');
            $table->string('website');
            $table->string('phone');
            $table->string('address');
            $table->string('logo')->nullable();// Allows storing NULL if no file is uploaded.
            $table->string('entreprise_description');
            $table->string('unique_identifier');
            $table->string('domaine');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruters');
    }
};
