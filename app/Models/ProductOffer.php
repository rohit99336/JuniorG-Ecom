<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'horizontal_subheading',
        'vertical_subheading',
        'heading',
        'offer_text',
        'button_text',
        'button_link',
        'offer_code',
        'offer_type',
        'offer_value',
        'offer_start_time',
        'offer_end_time',
        'image',
        'description',
        'is_active',
        'is_sel_all',
        'terms',
        'created_by',
        'updated_by',
    ];

    public function creater()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    /**
     * Get all of the offer items
     */
    public function offerItems()
    {
        return $this->hasMany(ProductOfferItem::class, 'product_offer_id');
    }
}
