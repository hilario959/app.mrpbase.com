<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class ProductionProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    public $timestamps = false;

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
