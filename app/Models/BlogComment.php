<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'blog_id',
        'first_name',
        'last_name',
        'email',
        'comment',
    ];

    /**
     * Get the blog that owns the comment.
     */
     public function blog()
     {
         return $this->belongsTo(Blog::class);
     }
}
