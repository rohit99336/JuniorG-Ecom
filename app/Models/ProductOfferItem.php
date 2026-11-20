<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOfferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_offer_id',
        'category_id',
        'product_id',
        'product_variant_id',
        'product_price',
        'discount_price',
        'discount_type',
        'discount_value',
        'discounted_price',
        'total',
        'total_discount',
        'grand_total',
    ];

    public function offer()
    {
        return $this->belongsTo(ProductOffer::class, 'product_offer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // public function getDiscountTypeAttribute($value)
    // {
    //     return $value == 'percentage' ? '%' : '₹';
    // }

    // public function setDiscountTypeAttribute($value)
    // {
    //     $this->attributes['discount_type'] = $value == '%' ? 'percentage' : 'fixed';
    // }
}
