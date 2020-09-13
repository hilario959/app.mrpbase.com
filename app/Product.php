<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @mixin Builder */
class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'price'
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class)
            ->withPivot('quantity');
    }
}
