<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'type',
        'client_numbers',
        'client_ids',
        'emails',
        'schedule_date',
        'schedule_time',
        'status',
    ];

    protected $casts = [
        'client_numbers' => 'array',
        'client_ids' => 'array',
        'emails' => 'array',
    ];

    public function messageTemplate()
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }

    public function client()
    {
        // get the clients using the client_ids array
        return $this->hasMany(Client::class, 'id', 'client_ids');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    // }

    // public function getScheduleDateAttribute($value)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    // }

    // public function setScheduleDateAttribute($value)
    // {
    //     $this->attributes['schedule_date'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    // }

    // public function getScheduleTimeAttribute($value)
    // {
    //     return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i:s');
    // }

    // public function setScheduleTimeAttribute($value)
    // {
    //     $this->attributes['schedule_time'] = \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i:s');
    // }

    // public function getStatusAttribute($value)
    // {
    //     return ucfirst($value);
    // }

    // public function setStatusAttribute($value)
    // {
    //     $this->attributes['status'] = strtolower($value);
    // }
}
