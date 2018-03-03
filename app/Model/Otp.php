<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    protected $guarded = [];
    /**
     * Get associated user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
