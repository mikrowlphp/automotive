<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Automotive\Garage\Enums\BodyType;
use Packages\Automotive\Garage\Enums\FuelType;
use Packages\Automotive\Garage\Enums\TransmissionType;

class CarVariant extends ObservableModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'car_model_id',
        'name',
        'engine_code',
        'engine_name',
        'displacement',
        'power_kw',
        'power_hp',
        'torque_nm',
        'fuel_type',
        'transmission',
        'body_type',
        'doors',
        'year_from',
        'year_to',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'displacement' => 'integer',
        'power_kw' => 'integer',
        'power_hp' => 'integer',
        'torque_nm' => 'integer',
        'doors' => 'integer',
        'year_from' => 'integer',
        'year_to' => 'integer',
        'is_active' => 'boolean',
        'fuel_type' => FuelType::class,
        'transmission' => TransmissionType::class,
        'body_type' => BodyType::class,
    ];

    /**
     * Get the car model that owns the variant.
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the vehicles for the variant.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the full name (Brand Model Variant).
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->carModel->carBrand->name} {$this->carModel->name} {$this->name}",
        );
    }

    /**
     * Get the power display string (e.g., "75 kW / 102 CV").
     */
    protected function powerDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->power_kw && $this->power_hp) {
                    return "{$this->power_kw} kW / {$this->power_hp} CV";
                }
                if ($this->power_kw) {
                    return "{$this->power_kw} kW";
                }
                if ($this->power_hp) {
                    return "{$this->power_hp} CV";
                }

                return null;
            },
        );
    }

    /**
     * Get the displacement display string (e.g., "1.6L" or "1560 cc").
     */
    protected function displacementDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->displacement) {
                    return null;
                }
                $liters = $this->displacement / 1000;

                return number_format($liters, 1).'L';
            },
        );
    }

    /**
     * Get the production years display string.
     */
    protected function yearsDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->year_from && $this->year_to) {
                    return "{$this->year_from} - {$this->year_to}";
                }
                if ($this->year_from) {
                    return "{$this->year_from} - oggi";
                }

                return null;
            },
        );
    }
}
