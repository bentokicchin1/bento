<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class MonthlyBills extends Model
{
    use SoftDeletes;
    protected $table = 'bill_payments';
}
