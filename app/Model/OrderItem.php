<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
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

    public function orderDish()
    {
       return $this->belongsTo('App\Model\Dish','dish_id');
    }
}
