<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperativeSetting extends Model
{
    protected $fillable = [
        'title',
        'heading',
        'description',
        'benefits',
        'outlines',
        'image_url',
        'gallery_images',
        'video_url',
        'application_link',
        'cta_text',
        'stats_members',
        'stats_investments',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];
}
