<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createFeedbacks();
    }

    public function createFeedbacks()
    {
        $candidates = Candidate::all();

        if ($candidates->isEmpty()) {
            return; // Skip if no candidates exist
        }

        $feedbackMessages = [
            "L'interface utilisateur est très intuitive et facile à utiliser. Excellent travail!",
            "Le processus de candidature pourrait être simplifié. Trop d'étapes actuellement.",
            "J'aimerais avoir plus d'informations sur les entreprises avant de postuler.",
            "La fonctionnalité de recherche d'emploi fonctionne très bien. Merci!",
            "Il serait bien d'avoir des notifications push pour les nouvelles offres.",
            "Le système de matching avec les offres d'emploi est très efficace.",
            "J'ai eu quelques problèmes techniques lors de l'upload de mon CV.",
            "La plateforme est excellente pour trouver des opportunités de carrière.",
            "Les tests en ligne sont bien conçus et pertinents.",
            "Il manque une fonctionnalité de chat avec les recruteurs.",
            "Le design de la plateforme est moderne et professionnel.",
            "J'aimerais pouvoir sauvegarder mes recherches d'emploi.",
            "Les alertes email fonctionnent parfaitement. Très utile!",
            "La section profil candidat pourrait être plus détaillée.",
            "Excellente plateforme pour les jeunes diplômés comme moi.",
            "Le processus de validation des comptes est un peu long.",
            "J'apprécie la variété des offres d'emploi disponibles.",
            "Il serait bien d'avoir des statistiques sur mes candidatures.",
            "La fonctionnalité de feedback est une excellente idée!",
            "Plateforme très professionnelle, je la recommande vivement."
        ];

        // Create 1-3 feedbacks for random candidates
        $feedbackCount = rand(15, 25);
        
        for ($i = 0; $i < $feedbackCount; $i++) {
            $candidate = $candidates->random();
            $message = $feedbackMessages[array_rand($feedbackMessages)];
            
            Feedback::create([
                'message' => $message,
                'candidate-id' => $candidate->id,
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
