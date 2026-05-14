<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperativeApplication extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'occupation',
        'matric_number',
        'graduation_year',
        'address',
        'reason',
        'status',
        'admin_notes',
    ];
}
