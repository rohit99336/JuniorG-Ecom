<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'title',
        'content',
        'thumbnail_img',
        'meta_keywords',
        'meta_description',
        'created_by',
        'category_id',
        'tag'
    ];

    /**
     * Cast ing attributes
     */
    protected $casts = [
        'tag' => 'array'
    ];

    /**
     * Get the user that owns the blog
     */
    public function createdby()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /*
     * Relationship between Blog and Category
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get many tags for a blog
     */
    public function tags()
    {
        return $this->belongsToMany(BlogTag::class);
    }

    /**
     * Get many comments for a blog
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
