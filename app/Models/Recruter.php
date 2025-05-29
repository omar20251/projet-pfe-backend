<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruter extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'entreprise_name',
        'website',
        'phone',
        'address',
        'logo',
        'entreprise_description',
        'unique_identifier',
        'domaine',
        'user_id',
        
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
