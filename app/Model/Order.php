<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_type_id', 'quantity', 'total_amount', 'shipping_address', 'status'];

    /**
     * Get the order items associated with the order.
     */
    public function orderItems()
    {
        return $this->hasMany('App\Model\OrderItem');
    }

}
