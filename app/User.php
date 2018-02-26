<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile_number', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get verified user id associated user.
     */
    public function verifyUser(){
        return $this->hasOne('App\Model\VerifyUser');
    }
    
    /**
     * Get verified user id associated otp.
     */
    public function verifyOtp(){
        return $this->hasOne('App\Model\Otp');
    }
}
