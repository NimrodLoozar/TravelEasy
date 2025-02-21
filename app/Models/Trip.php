<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'departure_id',
        'destination_id',
        'flight_number',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'trip_status',
        'is_active',
        'note'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime',
        'arrival_date' => 'date',
        'arrival_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Scope for active trips
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method to check if trip is active
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Helper method to get formatted departure datetime
    public function getDepartureDateTimeAttribute(): string
    {
        return $this->departure_date->format('Y-m-d') . ' ' . $this->departure_time->format('H:i:s');
    }

    // Helper method to get formatted arrival datetime
    public function getArrivalDateTimeAttribute(): string
    {
        return $this->arrival_date->format('Y-m-d') . ' ' . $this->arrival_time->format('H:i:s');
    }
}