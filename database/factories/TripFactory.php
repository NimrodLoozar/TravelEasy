<?php

namespace Database\Factories;

use App\Models\Departure;
use App\Models\Destination;
use App\Models\Employee;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'departure_id' => Departure::factory(),
            'destination_id' => Destination::factory(),
            'flight_number' => 'FL' . rand(1000, 9999),
            'departure_date' => $this->faker->date(),
            'departure_time' => $this->faker->time(),
            'arrival_date' => $this->faker->date(),
            'arrival_time' => $this->faker->time(),
            'trip_status' => 'active',
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}