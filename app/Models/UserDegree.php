<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDegree extends Model
{
    protected $fillable = [
        'user_id',
        'degree_type',
        'course',
        'department',
        'graduation_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
