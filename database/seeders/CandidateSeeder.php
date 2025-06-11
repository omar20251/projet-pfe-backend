<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCandidates();

        // Create additional random candidates using factory
        \App\Models\Candidate::factory()->count(15)->create();
    }

    public function createCandidates()
    {
        // Create specific candidate users first
        $candidateUsers = [
            [
                'first_name' => 'Amira',
                'last_name' => 'Ben Salem',
                'email' => 'amira.bensalem@email.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Youssef',
                'last_name' => 'Gharbi',
                'email' => 'youssef.gharbi@email.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Salma',
                'last_name' => 'Jebali',
                'email' => 'salma.jebali@email.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'en attente de validation',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Omar',
                'last_name' => 'Bouazizi',
                'email' => 'omar.bouazizi@email.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Nour',
                'last_name' => 'Hamdi',
                'email' => 'nour.hamdi@email.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'non valide',
                'remember_token' => Str::random(10),
            ]
        ];

        $candidateProfiles = [
            [
                'civility' => 'Mlle',
                'birth_date' => '1995-03-15',
                'Governorate' => 'Tunis'
            ],
            [
                'civility' => 'M',
                'birth_date' => '1993-07-22',
                'Governorate' => 'Sfax'
            ],
            [
                'civility' => 'Mlle',
                'birth_date' => '1996-11-08',
                'Governorate' => 'Sousse'
            ],
            [
                'civility' => 'M',
                'birth_date' => '1994-01-30',
                'Governorate' => 'Monastir'
            ],
            [
                'civility' => 'Mlle',
                'birth_date' => '1997-05-12',
                'Governorate' => 'Ariana'
            ]
        ];

        // Create users and their corresponding candidate profiles
        foreach ($candidateUsers as $index => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            $candidateData = $candidateProfiles[$index];
            $candidateData['user_id'] = $user->id;

            Candidate::firstOrCreate(
                ['user_id' => $user->id],
                $candidateData
            );
        }
    }
}
