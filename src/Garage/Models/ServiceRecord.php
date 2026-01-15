<?php

namespace Packages\Automotive\Garage\Models;

use App\Models\ObservableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Core\Contacts\Models\Contact;

class ServiceRecord extends ObservableModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'diagnosis_id',
        'vehicle_id',
        'customer_id',
        'service_date',
        'mileage_at_service',
        'status',
        'type',
        'parameters',
        'notes',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'service_date' => 'date',
        'mileage_at_service' => 'integer',
        'status' => ServiceRecordStatus::class,
        'type' => ServiceType::class,
        'parameters' => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the diagnosis for the service record.
     */
    public function diagnosis(): BelongsTo
    {
        return $this->belongsTo(Diagnosis::class);
    }

    /**
     * Get the vehicle for the service record.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the customer for the service record.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Get the lines for the service record.
     */
    public function lines(): HasMany
    {
        return $this->hasMany(ServiceRecordLine::class);
    }

    /**
     * Get a specific parameter value.
     */
    public function getParameter(string $key, mixed $default = null): mixed
    {
        return data_get($this->parameters, $key, $default);
    }

    /**
     * Set a specific parameter value.
     */
    public function setParameter(string $key, mixed $value): self
    {
        $parameters = $this->parameters ?? [];
        data_set($parameters, $key, $value);
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Check if a parameter exists.
     */
    public function hasParameter(string $key): bool
    {
        return data_get($this->parameters, $key) !== null;
    }
}
