<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    protected $fillable = [
        'production_id',
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

        self::deleting(function (Inventory $model) {
            $model->material()->increment('amount', $model->quantity * -1);
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
