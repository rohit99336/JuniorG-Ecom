<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\TwoFactorAuthenticatable;



class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'name',
        'last_name',
        'email',
        'password',
        'password_reset_token',
        'password_reset_at',
        'phone',
        'phone2',
        'otp',
        'otp_verified_at',
        'address',
        'zip_code',
        'gst_number',
        'pan_number',
        'aadhar_number',
        'state_id',
        'city_id',
        'pincode_id',
        'avatar',
        'google_id',
        'remember_token',
        'gender',
        'dob',
        'default_address_id',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
        'restored_by',
        'force_deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the reviews that owns the customer.
     */
    public function reviews()
    {
        return $this->hasMany(ProductRating::class, 'id', 'customer_id');
    }

    /**
     * Get the addresses that owns the customer.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'id', 'customer_id');
    }

    /**
     * Get the orders that owns the customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'customer_id');
    }

    /**
     * Get state that owns the customer.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Get city that owns the customer.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Get the deleted by that owns the customer.
     */
    public function deletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'deleted_by');
    }

    /**
     * Get the created by that owns the customer.
     */
    public function createdBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /**
     * Get the updated by that owns the customer.
     */
    public function updatedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    /**
     * Get the restored by that owns the customer.
     */
    public function restoredBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'restored_by');
    }

    /**
     * Get the force deleted by that owns the customer.
     */
    public function forceDeletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'force_deleted_by');
    }

    /**
     * Get customer default address here type is default
     */
    public function defaultAddress()
    {
        return $this->hasOne(Address::class, 'customer_id', 'id')->where('type', 'default');
    }

    /**
     * Get name in first letter capital
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * create a full name of customer
     */
    public function getFullnameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }
}
