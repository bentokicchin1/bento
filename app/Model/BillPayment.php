<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class BillPayment extends Model
{
    use SoftDeletes;
    protected $table = 'bill_payments';
    protected $hidden = ["deleted_at"];

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}