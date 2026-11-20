<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_number',
        'customer_id',
        'shipping_address_id',
        'billing_address_id',
        'shipping_method_id',
        'payment_method_id',
        'coupon_id',
        'status_id',
        'currency_id',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'payment_gateway',
        'payment_id',
        'payment_method',
        'payment_status',
        'payment_details',
        'shipping_number',
        'shipping_details',
        'shipping_status',
        'shipping_label',
        'tracking_number',
        'tracking_link',
        'tracking_details',
        'tracking_status',
        'tracking_label',
        'tracking_shipped',
        'tracking_delivered',
        'tracking_delivery_date',
        'tracking_delivery_time',
        'status',
        'notes',
        'customer_notes',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the shipping address that owns the order.
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id')->where('type', 'shipping');
    }


    /**
     * Get the billing address that owns the order.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id')->where('type', 'billing');
    }

    /**
     * Get the deleted by that owns the order.
     */
    public function deletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'deleted_by');
    }

    /**
     * Get payments for the order.
     */
    public function OrderPayments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

    /**
     * Get Invoice for the order.
     */
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    /**
     * Get status first letter uppercase.
     */
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get order status options.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function OrderStatus()
    {
        return self::where('id', '>', 0)->distinct()->pluck('status');
    }

    /**
     * Get all possible values of the enum column 'status'.
     *
     * @return array
     */
    public static function getAllStatusOptions()
    {
        $table = with(new static)->getTable();
        $column = 'status';

        // Retrieve enum values from the database schema
        $enumValues = DB::select("SHOW COLUMNS FROM $table WHERE Field = '$column'")[0]->Type;

        // Extract enum values from the column type string
        preg_match("/^enum\(\'(.*)\'\)$/", $enumValues, $matches);

        // Return enum values as array
        return explode("','", $matches[1]);
    }

    /**
     * Get all column names for the order.
     */
    protected function getColumnsForOrderQuery(): array
    {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        return $columns;
    }
}
