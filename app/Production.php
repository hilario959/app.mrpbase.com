<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Production extends Model
{
    public const PREFIX = 'PO';

    protected $fillable = [
        'start_at',
        'end_at'
    ];

    protected $dates = [
        'start_at', 'end_at'
    ];

    public function getTokenAttribute()
    {
        return self::PREFIX . '-' . ($this->attributes['id'] ?? '');
    }

    public function products()
    {
        return $this->hasMany(ProductionProduct::class);
    }
}
