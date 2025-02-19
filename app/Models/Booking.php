<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'trip_id',
        'seat_number',
        'purchase_date',
        'purchase_time',
        'booking_status',
        'price',
        'quantity',
        'special_requests',
        'is_active',
        'note'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_time' => 'datetime',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}