<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Recruter;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RecruterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRecruiters();
    }

    public function createRecruiters()
    {
        // Create recruiter users first
        $recruiterUsers = [
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Ben Ali',
                'email' => 'ahmed.benali@techcorp.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Fatma',
                'last_name' => 'Trabelsi',
                'email' => 'fatma.trabelsi@innovate.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Karray',
                'email' => 'mohamed.karray@digitalplus.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'en attente de validation',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Leila',
                'last_name' => 'Mansouri',
                'email' => 'leila.mansouri@webstudio.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Karim',
                'last_name' => 'Bouazizi',
                'email' => 'karim.bouazizi@startuptech.tn',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'non valide',
                'remember_token' => Str::random(10),
            ]
        ];

        $recruiterProfiles = [
            [
                'entreprise_name' => 'TechCorp Tunisia',
                'website' => 'https://techcorp.tn',
                'phone' => '+216 71 123 456',
                'address' => 'Avenue Habib Bourguiba, Tunis 1000',
                'logo' => 'techcorp_logo.png',
                'entreprise_description' => 'Leading technology company specializing in software development and digital transformation.',
                'unique_identifier' => 'TC001TN',
                'domaine' => 'Informatique'
            ],
            [
                'entreprise_name' => 'Innovate Solutions',
                'website' => 'https://innovate.tn',
                'phone' => '+216 71 234 567',
                'address' => 'Rue de la Liberté, Sfax 3000',
                'logo' => 'innovate_logo.png',
                'entreprise_description' => 'Innovative solutions provider for businesses across various industries.',
                'unique_identifier' => 'IS002TN',
                'domaine' => 'Conseil'
            ],
            [
                'entreprise_name' => 'Digital Plus',
                'website' => 'https://digitalplus.tn',
                'phone' => '+216 71 345 678',
                'address' => 'Zone Industrielle, Sousse 4000',
                'logo' => 'digitalplus_logo.png',
                'entreprise_description' => 'Digital marketing and e-commerce solutions company.',
                'unique_identifier' => 'DP003TN',
                'domaine' => 'Marketing'
            ],
            [
                'entreprise_name' => 'WebStudio Creative',
                'website' => 'https://webstudio.tn',
                'phone' => '+216 71 456 789',
                'address' => 'Centre Ville, Monastir 5000',
                'logo' => 'webstudio_logo.png',
                'entreprise_description' => 'Creative web design and development studio.',
                'unique_identifier' => 'WS004TN',
                'domaine' => 'Design'
            ],
            [
                'entreprise_name' => 'StartupTech Hub',
                'website' => 'https://startuptech.tn',
                'phone' => '+216 71 567 890',
                'address' => 'Technopole El Ghazala, Ariana 2083',
                'logo' => 'startuptech_logo.png',
                'entreprise_description' => 'Technology incubator and startup accelerator.',
                'unique_identifier' => 'ST005TN',
                'domaine' => 'Incubation'
            ]
        ];

        // Create users and their corresponding recruiter profiles
        foreach ($recruiterUsers as $index => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            $recruiterData = $recruiterProfiles[$index];
            $recruiterData['user_id'] = $user->id;

            Recruter::firstOrCreate(
                ['user_id' => $user->id],
                $recruiterData
            );
        }
    }
}
