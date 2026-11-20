<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcomAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guard = 'ecomadmin';

    protected $fillable = [
        'name',
        'employee_id',
        'section',
        'email',
        'password',
        'phone',
        'phone2',
        'address',
        'state_id',
        'city_id',
        'pincode_id',
        'avatar',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the state that owns the admin.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the city that owns the admin.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Get the user who created this admin.
     */
    public function createdBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'created_by');
    }

    /**
     * Get the user who updated this admin.
     */
    public function updatedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'updated_by');
    }

    /**
     * Get the user who deleted this admin.
     */
    public function deletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'deleted_by');
    }
}
