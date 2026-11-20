<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'session_id',
        'ip_address',
        'customer_id',
        'category_id',
        'product_id',
        'name',
        'image',
        'product_variant_id',
        'quantity',
        'price',
        'total',
        'discount',
        'tax',
        'shipping',
        'grand_total',
        'coupon_id',
        'coupon_discount',
        'coupon_discount_type',
        'coupon_discount_value',
    ];

    /**
     * Get the customer that owns the cart.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the category that owns the cart.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product that owns the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the cart.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
