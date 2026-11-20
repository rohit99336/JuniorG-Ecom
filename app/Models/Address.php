<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'order_id',
        'first_name',
        'last_name',
        'company',
        'address',
        'city',
        'country_id',
        'state_id',
        'zip',
        'phone',
        'email',
        'type',
    ];

    /**
     * Get the order that owns the address.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the country that owns the address.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the state that owns the address.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the customer that owns the address.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
