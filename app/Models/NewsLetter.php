<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_subscribed',
        'token',
        'subscribed_at',
        'unsubscribed_at',
        'token_expired_at',
        'last_sent_at',
        'last_opened_at',
        'last_clicked_at',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'region',
        'zip',
        'latitude',
        'longitude',
        'timezone',
        'currency',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'token_expired_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'last_opened_at' => 'datetime',
        'last_clicked_at' => 'datetime',
    ];

    public function scopeSubscribed($query)
    {
        return $query->where('is_subscribed', true);
    }

    public function scopeUnsubscribed($query)
    {
        return $query->where('is_subscribed', false);
    }

    public function scopeSubscribedAt($query, $date)
    {
        return $query->whereDate('subscribed_at', $date);
    }

}
