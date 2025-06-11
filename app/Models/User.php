<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasApiTokens,Notifiable;

    protected $guarded =[];
    //protected $fillable = ['firstname', 'lastname', 'email', 'password', 'role'];

  //  protected $hidden = ['password','remember_token'];
}

