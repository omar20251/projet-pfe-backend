<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'candidate_id',
        'user_answer',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
        // Une réponse appartient à une seule question 
    }
    
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
        // Une réponse appartient à un candidat
    }
     public function quizRequest()
    {
        return $this->hasOneThrough(QuizRequest::class, Question::class, 'id', 'id', 'question_id', 'quiz_request_id');
    }

    // Scopes
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }
}
