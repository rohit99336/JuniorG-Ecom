<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExport extends Model
{
    use HasFactory;

    /**
     * Fillable fields for a ProductExport
     */
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'export_by',
        'name',
        'phone',
        'email',
        'address',
        'old_sctock',
        'current_sctock',
        'quantity',
        'price',
        'note',
        'status',
        'city',
        'state',
        'pincode',
        'status',
        'type',
        'deleted_by',
    ];

    /**
     * Get the product that owns the ProductExport
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant that owns the ProductExport
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the export by that owns the ProductExport
     */
    public function exportBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'export_by');
    }

    /**
     * Get the deleted by that owns the ProductExport
     */
    public function deletedBy()
    {
        return $this->belongsTo(EcomAdmin::class, 'deleted_by');
    }
}
