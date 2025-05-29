<?php

namespace App\Http\Controllers;

use App\Models\QuizRequest;
use App\Models\Question;
use App\Models\Answer;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    // QuizController.php
    public function generateQuiz(Request $request) {
    // 1. Appel à l'API IA
    $aiResponse = Http::post('https://api.groq.com/openai/v1/chat/completions', [
        'prompt' => "Génère 5 QCM sur {$request->skill} pour le niveau {$request->level}..."
    ])->body();

    // 2. Parse la réponse brute (exemple simplifié)
    $parsedData = $this->parseAIResponse($aiResponse);

    // 3. Crée le quiz en BDD
    $quiz = QuizRequest::create([
        'candidate_id' => auth()->id(),
        'skill' => $request->skill,
        'level' => $request->level,
        'status' => 'created'
    ]);

    foreach ($parsedData['questions'] as $q) {
        $question = Question::create([
            'quiz_request_id' => $quiz->id,
            'question_text' => $q['text'],
            'correct_answer' => $q['correct_answer']
        ]);

        foreach ($q['options'] as $option) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct']
            ]);
        }
    }

    // 4. Retourne un JSON structuré pour le front
    return response()->json([
        'quiz_id' => $quiz->id,
        'questions' => $parsedData['questions'] // Format propre
    ]);
}

// Méthode pour parser la réponse IA
private function parseAIResponse($rawText) {
    // ... Logique de parsing (ex: regex/split) ...
    return [
        'questions' => [
            [
                'text' => "Qu'est-ce qu'un décorateur ?",
                'options' => ["A) Fonction", "B) Pattern", ...],
                'correct_answer' => "B"
            ]
        ]
    ];
}

    
}