<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @mixin Builder */
class Material extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
