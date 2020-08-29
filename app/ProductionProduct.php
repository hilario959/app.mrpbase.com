<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * @mixin Builder
 */
class ProductionProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'remaining_quantity',
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

    public function scopeProductQuantities(Builder $query)
    {
        $tableName = 'order_product';
        return $query->addSelect(
            $this->getTable() . '.*',
                $tableName . '.remaining_quantity as product_remaining_quantity',
                $tableName . '.quantity as product_quantity'
            )->leftJoin($tableName, function (JoinClause $join) use ($tableName) {
                $join->on($tableName . '.product_id', '=', $this->getTable() . '.product_id')
                    ->whereColumn($tableName . '.order_id', '=', $this->getTable() . '.order_id');
            });
    }
}
