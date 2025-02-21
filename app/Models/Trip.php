<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    /** @use HasFactory<\Database\Factories\TripFactory> */
    use HasFactory;

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
