<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'payment_method',
        'transaction_id',
        'status',
        'amount',
        'currency',
        'payment_status',
        'payment_response',
        'payment_date',
        'payment_expiry',
        'payment_type',
        'payment_mode',
        'bank',
        'card_no',
        'card_type',
        'card_expiry_month',
        'card_expiry_year',
        'card_cvv',
        'card_holder_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get status  attribute first letter capital
     */
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get payment_type first letter capital
     */
    public function getPaymentTypeAttribute($value)
    {
        return ucfirst($value);
    }
}
