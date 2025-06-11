<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class CandidateFactory extends Factory
{
    
    public function definition(): array
    {$user = User::factory()->create([
        'role' => 3,
    ]);

    return [
        'user_id' => $user->id,
        'civility' => $this->faker->randomElement(['M', 'Mme', 'Mlle']),
        'birth_date' => $this->faker->date(),
        'Governorate' => $this->faker->randomElement([
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
        ]),
    ];
    }
}
