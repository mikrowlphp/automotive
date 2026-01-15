<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarBrand extends ObservableModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'logo',
        'country',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the car models for the brand.
     */
    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}
