<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Order extends Model
{
    public const STATUS_RECEIVED = 0;
    public const STATUS_PAID = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_DONE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'client_id',
        'status',
        'delivery_date',
        'notes'
    ];

    /**
     * Return relation with Supplier Model
     *
     *
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->using(OrderProduct::class)
            ->withPivot(['quantity', 'remaining_quantity']);
    }

    public function productionProducts()
    {
        return $this->hasMany(ProductionProduct::class);
    }

    public function isCompleted()
    {
        foreach ($this->products as $item) {
            if ($item->pivot->remaining_quantity > 0) {
                return false;
            }
        }

        return true;
    }
}
