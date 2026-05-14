<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'category',
        'image_url',
        'badge',
        'is_spotlight',
        'description',
        'quantity',
        'sizes',
        'original_price',
        'delivery_fee'
    ];
}
