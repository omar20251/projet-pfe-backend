<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [ //this is for security : these 2 fields need to be secured
        'message',
        'candidate-id'
    ];
    protected $table='feedbacks';
    public function candidates()
    {
        return $this->belongsTo(Candidate::class,'candidate-id');
    }
    
}
