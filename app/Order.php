<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
}
