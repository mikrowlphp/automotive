<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Core\Shared\Models\Contact;

class Vehicle extends ObservableModel
{
    use HasFactory;

    protected static function newFactory(): \Packages\Automotive\Garage\Database\Factories\VehicleFactory
    {
        return \Packages\Automotive\Garage\Database\Factories\VehicleFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'car_model_id',
        'license_plate',
        'vin',
        'color',
        'year',
        'mileage',
        'fuel_type',
        'engine',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the customer that owns the vehicle.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Get the car model for the vehicle.
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the service records for the vehicle.
     */
    public function serviceRecords(): HasMany
    {
        return $this->hasMany(ServiceRecord::class);
    }
}
