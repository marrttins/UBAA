<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBroadcast extends Model
{
    protected $fillable = [
        'subject',
        'message',
        'recipient_type',
        'recipient_ids',
        'total_sent',
        'sent_by',
        'sent_at',
    ];

    protected $casts = [
        'recipient_ids' => 'array',
        'sent_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
