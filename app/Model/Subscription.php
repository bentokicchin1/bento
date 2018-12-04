<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
      use SoftDeletes;
      protected $hidden = ["deleted_at"];
}
