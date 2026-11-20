<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcomMaster extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'logo',
        'title',
        'meta_description',
        'meta_keywords',
        'email',
        'phone',
        'whatsapp',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'address',
        'map_link',
        'about',
        'start_time',
        'close_time',
        'shipping_charge',
        'free_shipping_amount',
        'return_days',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * get start_time am or pm
     */
    public function getStartTimeAttribute($value)
    {
        return date('h:i A', strtotime($value));
    }

    /**
     * get close_time am or pm
     */
    public function getCloseTimeAttribute($value)
    {
        return date('h:i A', strtotime($value));
    }
}
