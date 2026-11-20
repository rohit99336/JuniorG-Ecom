<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the admin that created the color.
     */
    public function creater()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /**
     * Get the admin that updated the color.
     */
    public function updater()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }
}
