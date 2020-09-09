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

    public function material()
    {
        return $this->belongsTo('App\Material', 'material_id');
    }
}
