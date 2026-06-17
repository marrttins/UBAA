<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'description',
        'amount',
        'status',
        'payment_method',
        'proof_of_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
