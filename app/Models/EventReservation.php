<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventReservation extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'amount',
        'payment_method',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
