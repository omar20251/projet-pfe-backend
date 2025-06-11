<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        $this->createUsers();
     //User::factory(3)->create(); //create 3 fake users in the DB
     
    }

    public function createUsers()
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@elyosdigital.com'],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 1,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ]
        );

        // Create recruiter user if not exists
        User::firstOrCreate(
            ['email' => 'recruteur@elyosdigital.com'],
            [
                'first_name' => 'recruteur',
                'last_name' => 'recruteur',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 2,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ]
        );

        // Create candidate user if not exists
        User::firstOrCreate(
            ['email' => 'candidat@elyosdigital.com'],
            [
                'first_name' => 'candidat',
                'last_name' => 'candidat',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 3,
                'statut' => 'valide',
                'remember_token' => Str::random(10),
            ]
        );
    }
}
