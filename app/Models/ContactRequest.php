<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'reply',
        'status',
        'replied_by',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the replied_by that owns the ContactRequest
     */
    public function replied_by()
    {
        return $this->belongsTo(EcomAdmin::class, 'replied_by');
    }
}
