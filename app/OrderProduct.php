<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'remaining_quantity',
        'price'     
    ];

    /**
     * Return relation with Supplier Model
     *
     *
     */
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
