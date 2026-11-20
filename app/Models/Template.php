<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'msg_temp_id',
        'subject',
        'cc',
        'bcc',
        'message',
        'type',
        'status',
        'event_name',
        'media_file',
        'for',
    ];

    protected $casts = [
        'cc' => 'array',
        'bcc' => 'array',
    ];

    // public function getMediaFileAttribute($value)
    // {
    //     return json_decode($value);
    // }

    // public function setMediaFileAttribute($value)
    // {
    //     $this->attributes['media_file'] = json_encode($value);
    // }

    // public function getBccAttribute($value)
    // {
    //     return json_decode($value);
    // }

    // public function setBccAttribute($value)
    // {
    //     $this->attributes['bcc'] = json_encode($value);
    // }

    // public function getCcAttribute($value)
    // {
    //     return json_decode($value);
    // }

    // public function setCcAttribute($value)
    // {
    //     $this->attributes['cc'] = json_encode($value);
    // }

    // public function getCreatedAtAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    // }
}
