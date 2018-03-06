<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['user_id', 'value'];
}
