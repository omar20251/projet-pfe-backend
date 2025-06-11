<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in the correct order due to foreign key constraints
        $this->call([
            DomaineSeeder::class,      // First - no dependencies
            UserSeeder::class,         // Second - no dependencies
            CandidateSeeder::class,    // Third - depends on User
            RecruterSeeder::class,     // Fourth - depends on User
            OffreSeeder::class,        // Fifth - depends on Recruter
            CandidatureOffreSeeder::class, // Sixth - depends on Candidate and Offre
            FeedbackSeeder::class,     // Seventh - depends on Candidate
            QuizSeeder::class,         // Eighth - depends on Candidate
        ]);
    }
}
