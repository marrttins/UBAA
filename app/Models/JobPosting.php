<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'title', 
        'position', 
        'company', 
        'description', 
        'deadline', 
        'logo_url', 
        'salary_range', 
        'environment', 
        'is_current_employee', 
        'link',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
