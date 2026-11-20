<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'approved_by',
        'title',
        'body',
        'thumbnail',
        'views',
        'likes',
        'dislikes',
        'is_published',
        'status',
        'approve_at',
    ];

    /**
     * Get the customer that owns the post.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the admin that approved the post.
     */
    public function approvedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'approved_by');
    }

    /**
     * Get the own post comments for the post.
     */
    public function comments()
    {
        // return $this->hasMany(PostComment::class);

        // get comments for the post where the parent_id is null
        return $this->hasMany(PostComment::class)->whereNull('parent_id');
    }
}
