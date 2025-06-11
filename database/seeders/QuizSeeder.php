<?php

namespace Database\Seeders;

use App\Models\QuizRequest;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createQuizzes();
    }

    public function createQuizzes()
    {
        $candidates = Candidate::all();

        if ($candidates->isEmpty()) {
            return; // Skip if no candidates exist
        }

        $skills = ['JavaScript', 'PHP', 'Python', 'Java', 'React', 'Laravel', 'Node.js', 'Vue.js'];
        $levels = ['junior', 'intermediate', 'senior'];

        // Create quiz requests for random candidates
        foreach ($candidates->take(8) as $candidate) {
            $skill = $skills[array_rand($skills)];
            $level = $levels[array_rand($levels)];
            
            $quizRequest = QuizRequest::create([
                'candidate_id' => $candidate->id,
                'skill' => $skill,
                'level' => $level,
                'message' => "Quiz request for {$skill} at {$level} level",
                'status' => 'completed',
                'requested_at' => now()->subDays(rand(1, 30)),
                'completed_at' => now()->subDays(rand(0, 15)),
                'score' => rand(60, 100),
            ]);

            // Create questions for this quiz
            $this->createQuestionsForQuiz($quizRequest, $skill);
        }

        // Create some pending quiz requests
        foreach ($candidates->take(5) as $candidate) {
            $skill = $skills[array_rand($skills)];
            $level = $levels[array_rand($levels)];
            
            QuizRequest::create([
                'candidate_id' => $candidate->id,
                'skill' => $skill,
                'level' => $level,
                'message' => "Pending quiz request for {$skill} at {$level} level",
                'status' => 'created',
                'requested_at' => now()->subDays(rand(1, 7)),
                'completed_at' => null,
                'score' => null,
            ]);
        }
    }

    private function createQuestionsForQuiz($quizRequest, $skill)
    {
        $questionsData = $this->getQuestionsForSkill($skill);
        
        foreach ($questionsData as $questionData) {
            $question = Question::create([
                'quiz_request_id' => $quizRequest->id,
                'question_text' => $questionData['text'],
                'options' => json_encode($questionData['options']),
                'correct_answer' => $questionData['correct_answer'],
            ]);

            // Create a random answer for this question
            $userAnswer = ['A', 'B', 'C', 'D'][array_rand(['A', 'B', 'C', 'D'])];
            $isCorrect = $userAnswer === $questionData['correct_answer'];

            Answer::create([
                'question_id' => $question->id,
                'candidate_id' => $quizRequest->candidate_id,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ]);
        }
    }

    private function getQuestionsForSkill($skill)
    {
        $questions = [
            'JavaScript' => [
                [
                    'text' => 'Quel est le résultat de typeof null en JavaScript?',
                    'options' => ['A) "null"', 'B) "object"', 'C) "undefined"', 'D) "boolean"'],
                    'correct_answer' => 'B'
                ],
                [
                    'text' => 'Quelle méthode est utilisée pour ajouter un élément à la fin d\'un tableau?',
                    'options' => ['A) push()', 'B) pop()', 'C) shift()', 'D) unshift()'],
                    'correct_answer' => 'A'
                ],
                [
                    'text' => 'Qu\'est-ce que le hoisting en JavaScript?',
                    'options' => ['A) Une erreur', 'B) Un comportement de déplacement des déclarations', 'C) Une fonction', 'D) Un opérateur'],
                    'correct_answer' => 'B'
                ]
            ],
            'PHP' => [
                [
                    'text' => 'Quel symbole est utilisé pour déclarer une variable en PHP?',
                    'options' => ['A) @', 'B) #', 'C) $', 'D) %'],
                    'correct_answer' => 'C'
                ],
                [
                    'text' => 'Quelle fonction est utilisée pour inclure un fichier en PHP?',
                    'options' => ['A) include()', 'B) import()', 'C) require()', 'D) A et C'],
                    'correct_answer' => 'D'
                ],
                [
                    'text' => 'Comment démarrer une session en PHP?',
                    'options' => ['A) start_session()', 'B) session_start()', 'C) begin_session()', 'D) init_session()'],
                    'correct_answer' => 'B'
                ]
            ],
            'Python' => [
                [
                    'text' => 'Quel est le type de données pour stocker du texte en Python?',
                    'options' => ['A) text', 'B) string', 'C) str', 'D) char'],
                    'correct_answer' => 'C'
                ],
                [
                    'text' => 'Comment créer une liste vide en Python?',
                    'options' => ['A) list = []', 'B) list = ()', 'C) list = {}', 'D) list = ""'],
                    'correct_answer' => 'A'
                ],
                [
                    'text' => 'Quelle méthode est utilisée pour ajouter un élément à une liste?',
                    'options' => ['A) add()', 'B) append()', 'C) insert()', 'D) B et C'],
                    'correct_answer' => 'D'
                ]
            ]
        ];

        // Return questions for the skill, or default JavaScript questions
        return $questions[$skill] ?? $questions['JavaScript'];
    }
}
