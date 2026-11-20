<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'card_number',
        'card_holder_name',
        'expiry_month',
        'expiry_year',
        'cvv',
        'card_type',
        'last_four_digit',
        'brand',
        'funding',
        'country',
        'bank',
        'card_issuer',
        'card_category',
        'card_class',
        'card_product',
        'card_type_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCardNumberAttribute($value)
    {
        return '**** **** **** ' . substr($value, -4);
    }

    public function getCardHolderNameAttribute($value)
    {
        return ucfirst($value);
    }
}
