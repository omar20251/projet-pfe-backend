<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = ['civility', 'birth_date', 'Governorate', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }  //The belongsTo relationships specify that each candidate belongs to one User

    public function offres()
    {
        return $this->belongsToMany(Offre::class, 'candidate_offre')
                ->withPivot(['status'])
                ->withTimestamps();
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class,'candidate-id');
    }

    public function quizRequests() {
        return $this->hasMany(QuizRequest::class); 
        // Un candidat a plusieurs demandes de quiz
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
