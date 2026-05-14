<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'items',
        'total_amount',
        'reference',
        'delivery_mode',
        'delivery_address',
        'delivery_phone',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
