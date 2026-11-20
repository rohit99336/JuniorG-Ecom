<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'category_id',
        'product_id',
        'product_variant_id',
        'stock',
    ];

    /**
     * Cast the following fields to an instance of Carbon.
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    /**
     * Get the category that owns the ProductImage.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product that owns the ProductImage.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product_variant that owns the ProductImage.
     */
    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
