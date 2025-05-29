<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatureOffre extends Model
{
    protected $table = 'candidate_offre'; 
    protected $fillable = ['candidate_id', 'offre_id', 'status'];
    public $incrementing = false;
    protected $primaryKey = null;

}
