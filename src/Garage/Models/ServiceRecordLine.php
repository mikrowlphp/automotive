<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Automotive\Garage\Enums\ServiceLineType;
use Packages\Sales\Shared\Models\Product;

class ServiceRecordLine extends ObservableModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_record_id',
        'product_id',
        'type',
        'description',
        'quantity',
        'unit_price',
        'line_total',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'type' => ServiceLineType::class,
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    /**
     * Get the service record that owns the line.
     */
    public function serviceRecord(): BelongsTo
    {
        return $this->belongsTo(ServiceRecord::class);
    }

    /**
     * Get the product associated with this line.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
