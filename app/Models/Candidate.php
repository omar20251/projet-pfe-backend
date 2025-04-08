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
        return $this->belongsTo(User::class);
    }  //The belongsTo relationships specify that each candidate belongs to one User
}
