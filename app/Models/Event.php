<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'event_date',
        'event_month',
        'event_day',
        'location_type',
        'location_name',
        'description',
        'category',
        'fee',
        'image_url',
    ];

    public function reservations()
    {
        return $this->hasMany(EventReservation::class);
    }
}
