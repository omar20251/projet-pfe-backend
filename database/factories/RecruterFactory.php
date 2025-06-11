<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Recruter;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruterFactory extends Factory
{
    protected $model = Recruter::class;

    public function definition(): array
    {
        $user = User::factory()->create([
            'role' => 2, // Recruiter role
            'statut' => $this->faker->randomElement(['valide', 'en attente de validation', 'non valide'])
        ]);

        $domaines = [
            'Informatique', 'Marketing', 'Design', 'Conseil', 'Finance', 
            'Ressources Humaines', 'Vente', 'Production', 'Logistique', 'Qualité'
        ];

        return [
            'user_id' => $user->id,
            'entreprise_name' => $this->faker->company(),
            'website' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'logo' => $this->faker->imageUrl(200, 200, 'business', true, 'logo'),
            'entreprise_description' => $this->faker->paragraph(3),
            'unique_identifier' => strtoupper($this->faker->bothify('??###??')),
            'domaine' => $this->faker->randomElement($domaines),
        ];
    }
}
