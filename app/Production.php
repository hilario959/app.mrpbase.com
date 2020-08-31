<?php

namespace App;

use Carbon\Carbon;
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

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
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
