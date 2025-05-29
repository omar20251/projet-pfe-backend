<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        $this->baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    }

    /**
     * Générer des questions de quiz via Groq AI
     */
    public function generateQuizQuestions(string $skill, string $level, int $numberOfQuestions = 5)
    {
        try {
            $prompt = $this->buildPrompt($skill, $level, $numberOfQuestions);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => 'llama3-70b-8192',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un expert en recrutement technique. Tu génères des questions de quiz au format JSON strict.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Parser le JSON retourné par l'AI
                return $this->parseAIResponse($content);
            }

            throw new \Exception('Erreur API Groq: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('Erreur Groq Service: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Construire le prompt pour l'AI
     */
    private function buildPrompt(string $skill, string $level, int $numberOfQuestions): string
    {
        return "
        Génère exactement {$numberOfQuestions} questions de quiz pour évaluer les compétences en {$skill} niveau {$level}.

        Format de réponse OBLIGATOIRE (JSON strict) :
        {
            \"questions\": [
                {
                    \"question_text\": \"Votre question ici?\",
                    \"options\": [\"Texte option A\", \"Texte option B\", \"Texte option C\", \"Texte option D\"],
                    \"correct_answer\": \"A\"
                }
            ]
        }

        Critères IMPORTANTS :
        - Questions pertinentes pour le niveau {$level}
        - 4 options de réponse par question (texte complet)
        - correct_answer doit être uniquement la LETTRE (A, B, C, ou D)
        - A = première option, B = deuxième option, etc.
        - Difficultés progressives
        - Réponse uniquement en JSON, aucun texte supplémentaire
        ";
    }

    /**
     * Parser la réponse de l'AI
     */
    private function parseAIResponse(string $content): array
    {
        // Nettoyer la réponse (enlever markdown, espaces, etc.)
        $content = trim($content);
        $content = str_replace(['```json', '```'], '', $content);
        
        $decoded = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Réponse AI non valide: ' . json_last_error_msg());
        }

        if (!isset($decoded['questions']) || !is_array($decoded['questions'])) {
            throw new \Exception('Format de réponse AI incorrect');
        }

        // Valider et nettoyer chaque question
        $validatedQuestions = [];
        foreach ($decoded['questions'] as $question) {
            // Vérifier les champs requis
            if (!isset($question['question_text']) || !isset($question['options']) || !isset($question['correct_answer'])) {
                continue; // Skip cette question si incomplète
            }

            // Nettoyer et valider correct_answer
            $correctAnswer = trim(strtoupper($question['correct_answer']));
            if (!in_array($correctAnswer, ['A', 'B', 'C', 'D'])) {
                // Si l'AI n'a pas retourné une lettre, essayer de deviner
                $correctAnswer = 'A'; // Par défaut
            }

            $validatedQuestions[] = [
                'question_text' => $question['question_text'],
                'options' => $question['options'],
                'correct_answer' => $correctAnswer
            ];
        }

        if (empty($validatedQuestions)) {
            throw new \Exception('Aucune question valide générée par l\'AI');
        }

        return $validatedQuestions;
    }

    /**
     * Valider une réponse utilisateur
     */
    public function validateAnswer(string $userAnswer, string $correctAnswer): bool
    {
        // Nettoyer les deux réponses et comparer les lettres
        $userLetter = trim(strtoupper($userAnswer));
        $correctLetter = trim(strtoupper($correctAnswer));
        
        return $userLetter === $correctLetter;
    }
}