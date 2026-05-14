<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationProject extends Model
{
    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'raised_amount',
        'icon',
        'is_active'
    ];
}
