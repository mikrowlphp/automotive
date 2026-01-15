<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Core\Contacts\Models\Contact;

class Diagnosis extends ObservableModel
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        // Auto-fill customer_id from vehicle
        static::creating(function (Diagnosis $diagnosis) {
            if ($diagnosis->vehicle_id && ! $diagnosis->customer_id) {
                $diagnosis->customer_id = Vehicle::find($diagnosis->vehicle_id)?->customer_id;
            }
        });

        static::updating(function (Diagnosis $diagnosis) {
            if ($diagnosis->isDirty('vehicle_id') && $diagnosis->vehicle_id) {
                $diagnosis->customer_id = Vehicle::find($diagnosis->vehicle_id)?->customer_id;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'acceptance_date',
        'mileage_at_acceptance',
        'customer_complaint',
        'initial_diagnosis',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'acceptance_date' => 'date',
        'mileage_at_acceptance' => 'integer',
        'status' => DiagnosisStatus::class,
    ];

    /**
     * Get the vehicle for the diagnosis.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the customer for the diagnosis.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Get the service records for the diagnosis.
     */
    public function serviceRecords(): HasMany
    {
        return $this->hasMany(ServiceRecord::class);
    }
}
