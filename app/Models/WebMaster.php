<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebMaster extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'appointement_msg_temp_id',
        'appointement_mail_temp_id',
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
    ];
}
