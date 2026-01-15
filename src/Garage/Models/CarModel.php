<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends ObservableModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'car_brand_id',
        'name',
        'year_from',
        'year_to',
        'body_type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'year_from' => 'integer',
        'year_to' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the car brand that owns the car model.
     */
    public function carBrand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class);
    }

    /**
     * Get the car variants for the model.
     */
    public function carVariants(): HasMany
    {
        return $this->hasMany(CarVariant::class);
    }

    /**
     * Get the vehicles for the car model.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the full name (Brand Model).
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->carBrand->name} {$this->name}",
        );
    }
}
