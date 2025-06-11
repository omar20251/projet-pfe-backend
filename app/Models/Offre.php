<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'entreprise_name',
        'place',
        'open_postes',
        'experience',
        'education_level',
        'language',
        'description',
        'requirements',
        'salary',
        'publication_date',
        'expiration_date',
        'skills',
        'contract_type',
        'statut',
        'recruiter_id',
        'candidate_id',
        
    ];


    public function recruter()
    {
        return $this->belongsTo(Recruter::class);
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_offre')
                ->withPivot(['status'])
                ->withTimestamps();
    }
}
