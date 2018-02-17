<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'name', 'quantity', 'base_price', 'total_amount'];

    /**
     * Get the order record associated with the  order item.
     */
    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }
}
