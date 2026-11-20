<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    /**
     * Mass assign
     */
    protected $fillable = [
        'customer_id',
        'product_id',
        'product_variant_id',
        'rating',
        'message',
    ];


    /**
     * Get the customer that owns the product.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the product that owns the rating.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the rating.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
