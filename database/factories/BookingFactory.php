<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'trip_id' => Trip::factory(),
            'seat_number' => $this->faker->bothify('???-??'),
            'purchase_date' => $this->faker->date(),
            'purchase_time' => $this->faker->time(),
            'booking_status' => 'active',
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'quantity' => rand(1, 5),
            'special_requests' => $this->faker->text(),
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}