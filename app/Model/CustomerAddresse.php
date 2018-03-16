<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddresse extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsTo('App\Model\User','user_id');
    }
    public function cityData()
    {
        return $this->belongsTo('App\Model\City','city');
    }
    public function areaData()
    {
        return $this->belongsTo('App\Model\Area','area');
    }
    public function areaLocation()
    {
        return $this->belongsTo('App\Model\Area_location','sector');
    }
    public function orderType()
    {
        return $this->belongsTo('App\Model\OrderType','order_type_id');
    }

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }
}
