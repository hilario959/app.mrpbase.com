<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS_RECEIVED = 0;
    public const STATUS_PAID = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_DONE = 3;

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
