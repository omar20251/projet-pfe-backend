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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('civility', ['M', 'Mme', 'Mlle']);
            $table->date('birth_date');
            $table->enum('Governorate', [
                'Ariana',
                'Béja',
                'Ben Arous',
                'Bizerte',
                'Gabès',
                'Gafsa',
                'Jendouba',
                'Kairouan',
                'Kasserine',
                'Kébili',
                'Le Kef',
                'Mahdia',
                'La Manouba',
                'Médnine',
                'Monastir',
                'Nabeul',
                'Sfax',
                'Sidi Bouzid',
                'Siliana',
                'Sousse',
                'Tataouine',
                'Tozeur',
                'Tunis',
                'Zaghouan',
            ]);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');//The user_id is a foreign key to the users table, The onDelete('cascade') ensures that when a user or domain is deleted, the associated candidate record will be deleted as well.
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
