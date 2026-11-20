<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'payment_id',
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
        'deleted_by',
        'created_by',
        'updated_by',
        'restored_by',
        'force_deleted_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'deleted_by');
    }

    public function restoredBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'restored_by');
    }

    public function forceDeletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'force_deleted_by');
    }
}
