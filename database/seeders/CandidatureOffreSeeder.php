<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Offre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidatureOffreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createApplications();
    }

    public function createApplications()
    {
        $candidates = Candidate::all();
        $offres = Offre::where('statut', 'valide')->get();

        if ($candidates->isEmpty() || $offres->isEmpty()) {
            return; // Skip if no candidates or valid job offers exist
        }

        $statuses = ['pending', 'accepted', 'rejected', 'under_review'];
        $statusWeights = [40, 20, 25, 15]; // 40% pending, 20% accepted, 25% rejected, 15% under review

        // Each candidate applies to 1-5 random job offers
        foreach ($candidates as $candidate) {
            $applicationCount = rand(1, 5);
            $selectedOffers = $offres->random(min($applicationCount, $offres->count()));

            foreach ($selectedOffers as $offre) {
                // Check if application already exists
                $exists = DB::table('candidate_offre')
                    ->where('candidate_id', $candidate->id)
                    ->where('offre_id', $offre->id)
                    ->exists();

                if (!$exists) {
                    $status = $this->getWeightedRandomStatus($statuses, $statusWeights);
                    
                    DB::table('candidate_offre')->insert([
                        'candidate_id' => $candidate->id,
                        'offre_id' => $offre->id,
                        'status' => $status,
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(0, 15)),
                    ]);
                }
            }
        }

        // Create some additional random applications
        for ($i = 0; $i < 50; $i++) {
            $candidate = $candidates->random();
            $offre = $offres->random();

            // Check if application already exists
            $exists = DB::table('candidate_offre')
                ->where('candidate_id', $candidate->id)
                ->where('offre_id', $offre->id)
                ->exists();

            if (!$exists) {
                $status = $this->getWeightedRandomStatus($statuses, $statusWeights);
                
                DB::table('candidate_offre')->insert([
                    'candidate_id' => $candidate->id,
                    'offre_id' => $offre->id,
                    'status' => $status,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }

    private function getWeightedRandomStatus($statuses, $weights)
    {
        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$index];
            }
        }

        return $statuses[0]; // fallback
    }
}
