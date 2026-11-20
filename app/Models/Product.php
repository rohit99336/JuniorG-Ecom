<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'category_id',
        'meta_description',
        'meta_keywords',
        'schema',
        'unit_id',
        'color_id',
        'name',
        'slug',
        'unit_size',
        'unit_price',
        'short_description',
        'description',
        'sku',
        'barcode',
        'hsn_code',
        'min_quantity',
        'max_quantity',
        'quantity',
        'price',
        'cost',
        'shipping_cost',
        'special_price',
        'tax',
        'tax_type',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'is_featured',
        'is_bestseller',
        'is_active',
        'is_cod',
        'is_refundable',
        'tags',
        'thumbnail_image',
        'eastimate_shiping_time',
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
        'tags' => 'array',
    ];

    /**
     * Get the admin that created the product.
     */
    public function creater()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /**
     * Get the admin that updated the product.
     */
    public function updater()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit that owns the product.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the color that owns the product.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the product images for the product.
     */
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get Product variants for the product.
     */
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
