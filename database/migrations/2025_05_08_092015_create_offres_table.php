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
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('entreprise_name');
            $table->string('place');
            $table->string('open_postes');
            $table->string('experience');
            $table->string('education_level');
            $table->string('language');
            $table->string('description');
            $table->string('requirements');
            $table->double('salary');
            $table->date('publication_date');
            $table->date('expiration_date');
            $table->string('skills');
            $table->string('contract_type');
            $table->string('statut');
            $table->foreignId('recruiter_id')->constrained('recruters')->onDelete('cascade');
            //now what to do in terms of logic and security cuz when register another offer with the same request data its saved which doesnt make any sense cuz yes the recruiter id might be the same cuz 1 recruter can post lotta offers but not with the same data(name,description etc ...)?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
