<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
         'name',
         'slug',
    ];

    /**
     * Get the blog posts for the blog tag.
     */
    public function posts()
    {
        return $this->belongsToMany(Blog::class);
    }
}
