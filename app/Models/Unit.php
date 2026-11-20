<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'is_active',
        'created_by',
    ];

    /**
     * Get the admin that created the unit.
     */
    public function creater()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }
}
