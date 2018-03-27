<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerifyUser extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    protected $guarded = [];
    /**
     * Get associated user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
