<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'url',
        'position',
        'status',
        'order',
        'start_date',
        'end_date',
        'type',
        'description',
        'button_text',
        'button_url',
        'for',
        'media',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForSalon($query)
    {
        return $query->where('for', 'salon');
    }

    public function scopeForShop($query)
    {
        return $query->where('for', 'shop');
    }
}
