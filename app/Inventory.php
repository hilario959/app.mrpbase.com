<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    protected $fillable = [
        'material_id',
        'date_entry',
        'quantity',
        'notes'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function (Inventory $model) {
            $model->material()->increment('amount', $model->quantity);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
