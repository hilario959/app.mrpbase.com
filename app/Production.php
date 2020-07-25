<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'to_be_produced',
        'unique_id',
        'created_at',
        'updated_at'
    ];
}
