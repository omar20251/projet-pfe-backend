<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizRequest extends Model
{
     protected $fillable = [
        'candidate_id',
        'skill',
        'level',
        'status',
        'message',
        'requested_at',
        'completed_at',
        'score'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'completed_at' => 'datetime',
        'score' => 'decimal:2'
    ];

    public function questions() {
        return $this->hasMany(Question::class);
        // Un quiz peut avoir plusieurs questions
    }

    public function candidate() {
        return $this->belongsTo(Candidate::class);
        // Une demande de quiz appartient à un seul candidat
    }
    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeBySkill($query, $skill)
    {
        return $query->where('skill', $skill);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }
    
}
