<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'product_id',
        'color_id',
        'unit_id',
        'meta_description',
        'meta_keywords',
        'unit_size',
        'name',
        'slug',
        'unit_price',
        'sku',
        'barcode',
        'hsn_code',
        'min_quantity',
        'max_quantity',
        'quantity',
        'price',
        'org_price',
        'cost',
        'special_price',
        'discount_percentage',
        'discount_amount',
        'is_featured',
        'is_active',
        'is_cod',
        'is_refundable',
        'tags',
        'thumbnail_image',
        'created_by',
        'updated_by',
    ];

    /**
     * Cast the following fields to an instance of Carbon.
     */
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    /**
     * Array cast tags field to json.
     */
    protected $casts = [
        'tags' => 'json',
    ];

    /**
     * Get the product that owns the variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color that owns the variant.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the unit that owns the variant.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the admin that created the variant.
     */
    public function creater()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /**
     * Get the admin that updated the variant.
     */
    public function updater()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    /**
     * Get product images of the variant.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get product images of the variant.
     */
    public function reviews()
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Average  rating for this product variation.
     */
     public function avg_rating()
     {
         return $this->reviews()->avg('rating');
     }
}
