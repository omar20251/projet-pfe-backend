<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_request_id',
        'question_text',
        'options',
        'correct_answer'
    ];

    protected $casts = [
        'options' => 'array'
    ];
    public function quizRequest() {
        return $this->belongsTo(QuizRequest::class);
    }
    public function answers() {
        return $this->hasMany(Answer::class);  
    }
    // Accessors
    public function getOptionsArrayAttribute()
    {
        return is_string($this->options) ? json_decode($this->options, true) : $this->options;
    }
}
