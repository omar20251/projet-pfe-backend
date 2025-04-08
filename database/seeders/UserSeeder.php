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
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@elyosdigital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 1,
            'remember_token' => Str::random(10),
            //'status' => UserStatus::ACTIVE,
        ]);
        User::create([
            'first_name' => 'recruteur',
            'last_name' => 'recruteur',
            'email' => 'recruteur@elyosdigital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 2,

            'remember_token' => Str::random(10),
            //'status' => UserStatus::ACTIVE,
        ]);
        User::create([
            'first_name' => 'candidat',
            'last_name' => 'candidat',
            'email' => 'candidat@elyosdigital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 3,

            //'status' => UserStatus::ACTIVE,
        ]);
        
    }
}
